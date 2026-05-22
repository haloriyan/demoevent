<?php

namespace App\Http\Controllers;

use App\Jobs\MidtransCheckerX;
use App\Mail\EmailChanged;
use App\Mail\Expiring as MailExpiring;
use App\Mail\OrderCreated as MailOrderCreated;
use App\Mail\PaymentConfirmed;
use App\Mail\SubmissionNotifySystem as MailSubmissionNotifySystem;
use App\Mail\SubmissionNotifyUser as MailSubmissionNotifyUser;
use App\Models\Schedule;
use App\Models\Speaker;
use App\Models\Submission;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WaDevice;
use App\Models\Workshop;
use App\Models\WsCategory;
use App\Notifications\Expiring;
use App\Notifications\OrderCreated;
use App\Notifications\SubmissionNotifySystem;
use App\Notifications\SubmissionNotifyUser;
use App\Services\Doku;
use App\Services\Midtrans;
use App\Services\MidtransService;
use App\Services\Xendit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public $midtrans;

    public function __construct(Midtrans $mid)
    {
        $this->midtrans = $mid;
    }
    public function doku(Request $request, Doku $doku) {
        $trx = $doku->checkout([
            'invoice_number' => "CO123123",
            'amount' => 12500,
            'customer' => [
                'name' => "Riyan Satria",
                'email' => "riyan.satria.619@gmail.com"
            ]
        ]);

	// tes
        return $trx;
    }
    public function generateSignature($merchantCode, $merchantRef, $amount, $privateKey) {
        $signature = hash_hmac('sha256', $merchantCode.$merchantRef.$amount, $privateKey);
        return $signature;
    }
    public function xendit(Xendit $xendit) {
        // $merchantCode = "T48935"; // Live
        $merchantCode = "T38502";
        $privateKey = env('TRIPAY_PRIVATE_SANDBOX');
        $merchantRef = "INV124";
        $amountWithoutFee = 5000;
        $amount = $amountWithoutFee + (700 + (5 / 100 * $amountWithoutFee));
        $signature = hash_hmac('sha256', $merchantCode.$merchantRef.$amount, $privateKey);

        $response = Http::withHeaders([
            'Authorization' => "Bearer " . env('TRIPAY_API_SANDBOX')
        ])
        ->post("https://tripay.co.id/api-sandbox/transaction/create", [
            'signature' => $signature,
            'method' => "QRISC",
            'merchant_ref' => $merchantRef,
            'amount' => $amount,
            'customer_name' => "John Doe",
            'customer_email' => "john@doe.com",
            'customer_phone' => "085159772902",
            'order_items' => [
                [
                    'name' => "Produk digital",
                    'price' => $amount,
                    'quantity' => 1,
                ]
            ]
        ]);

        return $response->json();
    }
    public function submission($type = 'abstract') {
        $message = Session::get('message');
        return view('submission', [
            'type' => $type,
            'message' => $message,
        ]);
    }
    public function submissionSubmit(Request $request) {
        $email = $request->email;
        $type = $request->type;
        $user = User::where('email', $email)->with(['transaction.ticket'])->first();
        $eligible = true;
        $maxSize = 5;
        $maxSizeInKB = $maxSize * 1024;
        $mimeTypes = $type === "abstract" ? 
            "application/vnd.openxmlformats-officedocument.wordprocessingml.document" : 
            "application/pdf";

        $request->validate([
            'file' => [
                'required', 
                "mimetypes:{$mimeTypes}",
                "max:{$maxSizeInKB}"
            ]
        ], [
            'file.required' => "Lampiran tidak boleh kosong",
            'file.mimetypes' => "File harus berformat PDF",
            'file.max' => "Ukuran file tidak boleh melebihi " . $maxSize . " MB"
        ]);

        if ($user == null) {
            $eligible = false;
        } else {
            if ($user->transaction == null || @$user->transaction->payment_status != "PAID") {
                $eligible = false;
            }
        }

        if (!$eligible) {
            return redirect()->back()->withErrors([
                'Anda harus terdaftar sebagai peserta Simposium untuk mengirimkan poster / abstrak',
            ]);
        }

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();

        $submission = Submission::create([
            'user_id' => @$user->id ?? null,
            'name' => $request->name,
            'email' => $email,
            'type' => $type,
            'file' => $fileName,
        ]);

        $file->move(
            public_path('storage/submission_' . $type),
            $fileName
        );

        Mail::to($email)->send(
            new MailSubmissionNotifyUser([
                'submission' => $submission,
            ])
        );
        Mail::to('halo@pitperabdinasarelc2026.com')->send(
            new MailSubmissionNotifySystem([
                'submission' => $submission,
            ])
        );

        return redirect()->back()->with([
            'message' => "Berhasil mengirim submission " . ucwords($type)
        ]);
    }
    public function contact() {
        return view('contact');
    }
    public function eposter() {
        return view('eposter');
    }
    public function ramayana() {
        return view('ramayana.index');
    }
    public function program() {
        $schedules = Schedule::orderBy('date', 'ASC')
        ->with(['rundowns' => function ($query) {
            $query->orderBy('start_time', 'ASC');
        }])
        ->get();

        return view('program', [
            'schedules' => $schedules,
        ]);
    }
    public function index() {
        $speakers = Speaker::where('is_featured', true)
        ->orderBy('priority', 'ASC')
        ->get();
        
        $schedules = Schedule::orderBy('date', 'ASC')
        ->with(['rundowns' => function ($query) {
            $query->orderBy('start_time', 'ASC');
        }])
        ->get();

        return view('index', [
            'speakers' => collect($speakers),
            'schedules' => $schedules,
        ]);
    }
    public function search(Request $request) {
        $u = User::where('name', 'LIKE', "%".$request->q."%");
        if ($request->with != "") {
            $u = $u->with($request->with);
        }
        $users = $u->take(20)->get();

        return response()->json([
            'users' => $users,
        ]);
    }
    public function streamPdf($filename) {
        $filename = base64_decode($filename);
        $path = public_path('storage/handbooks/' . $filename);

        return Response::stream(function () use ($path) {
            $stream = fopen($path, 'rb');
            while (!feof($stream)) {
                echo fread($stream, 1024 * 8);
                ob_flush();
                flush();
            }
            fclose($stream);
        }, 200, [
            "Content-Type" => "application/pdf",
            "Content-Disposition" => "inline; filename=\"$filename\"",
            "Access-Control-Allow-Origin" => "*", // optional if frontend cross-origin
            "Cache-Control" => "no-cache",
        ]);
    }
    public function expiring() {
        $transactions = Transaction::where([
            ['payment_status', 'PENDING'],
            ['expired_at', '<', Carbon::now()]
        ])
        ->with(['user', 'ticket'])
        ->get();

        foreach ($transactions as $trx) {
            if (env('DO_BROADCAST') == 1) {
                try {
                    $user = $trx->user;
                    Mail::to($user->email)->send(new MailExpiring([
                        'trx' => $trx,
                    ]));
                    if ($user->whatsapp) {
                        send_wa(
                            $user->whatsapp,
                            "Yth. " . $user->name . "\n",
                            "Kami dari panitia " . env('EVENT_NAME') . "ingin menyampaikan terima kasih atas pendaftaran Anda.\n".
                            "Namun, kami mohon maaf untuk memberitahukan bahwa pendaftaran Anda terpaksa kami batalkan karena telah melewati batas waktu pembayaran. Sesuai dengan ketentuan yang berlaku, pendaftaran yang tidak disertai pembayaran dalam batas waktu yang ditentukan akan otomatis dibatalkan oleh sistem.\n".
                            "Kami memahami bahwa hal ini mungkin menimbulkan ketidaknyamanan. Jika Anda masih berminat untuk mengikuti " . env('EVENT_NAME') . ", Anda dapat melakukan pendaftaran ulang.\n\n".
                            route('register') . "\n\n".
                            "Kami sangat menghargai minat Anda untuk berpartisipasi dalam acara ini dan berharap Anda dapat bergabung bersama kami di ". env('EVENT_NAME') ." mendatang.\n" . 
                            "Jika Anda memiliki pertanyaan atau memerlukan bantuan, jangan ragu untuk menghubungi kami di " . env('EMAIL') . " atau " . env('PHONE') . ". \n\n" .
                            "Terima kasih atas partisipasi Anda.\n\n". 
                            "Hormat Kami,\n" . 
                            "Panitia ". env('EVENT_NAME')
                        );
                    }
                } catch (\Exception $e) {}
            }

            Transaction::where('id', $trx->id)->update([
                'payment_status' => "EXPIRED"
            ]);

            Ticket::where('id', $trx->ticket_id)->increment('quantity');
        }

        return $transactions;
    }
    public function register(Request $request, $step = 'detail') {
        $payload = json_decode(base64_decode($request->p), true) ?? [];
        $me = me();

        if ($step == "welcome") {
            if ($request->method() == "GET") {
                $categories = TicketCategory::with([
                    'tickets.category',
                    'tickets' => function ($query) {
                        $query->where([
                            ['quantity', '>', 0],
                            ['visible', true]
                        ]);
                    }
                ])->get();
                $workshops = WsCategory::with([
                    'workshops.rundown.speakers',
                    'workshops' => function ($query) {
                        $query->where('quantity', '>', 0);
                    }
                ])
                ->get();

                return view('register', [
                    'step' => $step,
                    'categories' => $categories,
                    'request' => $request,
                    'workshops' => $workshops,
                    'payload' => $payload,
                ]);
            } else {
                $tick = Ticket::where('id', $request->ticket_id);
                $ticket = $tick->first();

                $payload['ticket'] = $ticket;
                $payload['workshops'] = json_decode($request->workshops);

                return redirect()->route('register', [
                    'step' => "konfirmasi",
                    'p' => base64_encode(json_encode($payload)),
                ]);
            }
        }

        if ($step == "detail") {
            if ($request->method() == "GET") {
                return view('detail', [
                    'step' => $step,
                    'payload' => $payload,
                    'request' => $request,
                ]);
            } else {
                $request->validate([
                    'email' => "unique:users",
                    'nik' => "unique:users"
                ], [
                    'email.unique' => "Alamat email telah digunakan. Mohon gunakan yang lain",
                    'nik.unique' => "NIK telah digunakan.",
                ]);

                $payload['nik'] = $request->nik;
                $payload['name'] = $request->name;
                $payload['email'] = $request->email;
                $payload['whatsapp'] = $request->whatsapp;
                $payload['instansi'] = $request->instansi;

                return redirect()->route('register', [
                    'step' => "welcome",
                    'p' => base64_encode(json_encode($payload)),
                ]);
            }
        }

        if ($step == "konfirmasi") {
            if ($request->method() == "GET") {
                return view('confirm', [
                    'step' => $step,
                    'payload' => $payload,
                    'request' => $request,
                ]);
            } else {
                $ticketID = $payload['ticket']['id'];

                foreach ($payload['workshops'] ?? [] as $ws) {
                    $work = Workshop::where('id', $ws['id']);
                    $workshop = $work->first();

                    $work->update([
                        'count' => $workshop->count + 1,
                        'quantity' => $workshop->quantity - 1,
                    ]);
                }

                $user = User::firstOrCreate(
                    [
                        'nik' =>  $payload['nik'],
                        'email' =>  $payload['email'],
                        'instansi' =>  $payload['instansi'],
                    ],
                    [
                        'name' =>  $payload['name'],
                        'whatsapp' =>  $payload['whatsapp'],
                        'password' => bcrypt("default")
                    ]
                );
                
                $names = explode(" ", $user->name);

                // Create Transaction
                $trx = Transaction::create([
                    'user_id' => $user->id,
                    'ticket_id' => $ticketID,
                    'workshops' => json_encode($payload['workshops']),
                    'payment_status' => "PENDING",
                    'payment_amount' => $payload['ticket']['price'],
                    'expired_at' => Carbon::now()->addMinutes((int)env('PAYMENT_EXPIRATION'))->format('Y-m-d H:i:s'),
                ]);

                $orderID = "PIT_" . date('Ymd') . $trx->id;
                $emailDomain = explode("@", $user->email)[1];
                $amount = $payload['ticket']['price'];
                if (env('DOKU_MODE') != "live" || $emailDomain == 'pitperabdinasarelc2026.com' ) {
                    $amount = 10000;
                }
                $doku = new Doku();
                $payment = $doku->checkout([
                    'invoice_number' => $orderID,
                    'amount' => $amount,
                    'customer' => [
                        'name' => $user->name,
                        'email' => $user->email
                    ]
                ]);
                $payment['order_id'] = $orderID;

                $trx = Transaction::where('id', $trx->id);
                $trx->update([
                    'payment_payload' => json_encode($payment),
                    'invoice_number' => $orderID,
                ]);

                $trx = $trx->with(['ticket', 'user'])
                ->first();

                $payload['transaction'] = $trx;

                Ticket::where('id', $ticketID)->decrement('quantity');

                // DO NOTIF
                if (env('DO_BROADCAST') == 1) {
                    Mail::to($user->email)->send(new MailOrderCreated([
                        'user' => $user,
                        'trx' => $trx,
                    ]));

                    if ($user->whatsapp != null) {
                        $device = WaDevice::where('is_primary', true)->first();

                        Http::post(env('WA_URL') . "/send", [
                            'client_id' => $device->client_id,
                            'destination' => "62".$user->whatsapp,
                            'message' => "Yth. " . $user->name . "\n\n" .
                                         "Kami ingin mengkonfirmasi bahwa pendaftaran Anda untuk PIT PERABDIN - ASAR ELC 2026 telah berhasil.\n\n" . 
                                         "Berikut adalah detail pendaftaran Anda :\n".
                                         "NIK : " . ($user->nik ?? '-') . "\n" .
                                         "Nama Lengkap : " . $user->name. "\n".
                                         "Alamat Email : ". ($user->email ?? '-') . "\n" .
                                         "No. Telepon : ". ($user->whatsapp ?? '-') . "\n" .
                                         "Tiket : " . $trx->ticket->name . "\n" . 
                                         "No. Pendaftaran : " . $trx->id . "\n\n" .
                                         "PIT PERABDIN - ASAR ELC 20216 akan diselenggarakan pada :\n" .
                                         "- Tanggal : " . $trx->ticket->start_date . "\n\n" .
                                         "Kemudian mohon lakukan pembayaran melalui link berikut ini :\n".
                                         route('pembayaran.instan', $trx->id) . "\n\n" .
                                         "Jika Anda memiliki pertanyaan atau memerlukan bantuan, jangan ragu untuk menghubungi kami di " . env("EMAIL") . " atau melalui kontak WhatsApp ini.\n\n" .
                                         "Terima kasih atas partisipasi Anda\n\n".
                                         "Hormat Kami,\n ".
                                         "Panitia PIT PERABDIN - ASAR ELC 2026"
                        ]);
                    }
                }

                return redirect(
                    $payment['response']['payment']['url']
                );

                return redirect()->route('register', [
                    'step' => "done",
                    'p' => base64_encode(json_encode($payload)),
                ]);
            }
        }

        if ($step == "done") {
            $mailDomain = explode("@", $payload['email'])[1];

            return view('done', [
                'payload' => $payload,
                'mailDomain' => $mailDomain,
            ]);
        }
    }
    public function pembayaranInstan($trxID) {
        $trx = Transaction::where('id', $trxID);
        $transaction = $trx->with(['user', 'ticket'])->first();
        $payload = json_decode($transaction->payment_payload, false);

        return redirect($payload->payment['url']);
    }
    public function pembayaran(Request $request, $trxID) {
        $trx = Transaction::where('id', $trxID);
        $transaction = $trx->with(['user', 'ticket'])->first();

        if ($request->method() == "GET") {
            return view('pembayaran', [
                'transaction' => $transaction,
                'request' => $request,
            ]);
        } else {
            $image = $request->file('image');
            $imageFileName = $image->getClientOriginalName();
            $image->move(
                public_path('storage/payment_evidences'), $imageFileName
            );

            $trx->update([
                'payment_evidence' => $imageFileName,
            ]);

            return redirect()->route('pembayaran', [
                'id' => $trxID,
                'done' => 1,
            ]);
        }
    }
}
