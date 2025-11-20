<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\Expiring;
use App\Notifications\OrderCreated;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
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
                $trx->user->notify(new Expiring([
                    'trx' => $trx,
                ]));
            }

            Transaction::where('id', $trx->id)->update([
                'payment_status' => "EXPIRED"
            ]);

            Ticket::where('id', $trx->ticket_id)->increment('quantity');
        }

        return $transactions;
    }
    public function index(Request $request, $step = 'welcome') {
        $payload = json_decode(base64_decode($request->p), true) ?? [];
        $me = me();

        if ($step == "welcome") {
            if ($request->method() == "GET") {
                $categories = TicketCategory::with([
                    'tickets' => function ($query) {
                        $query->where([
                            ['quantity', '>', 0],
                            ['visible', true]
                        ]);
                    }
                ])->get();

                return view('index', [
                    'step' => $step,
                    'categories' => $categories,
                    'request' => $request,
                ]);
            } else {
                $tick = Ticket::where('id', $request->ticket_id);
                $ticket = $tick->first();

                $payload['ticket'] = $ticket;

                return redirect()->route('index', [
                    'step' => "detail",
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
                $payload['nik'] = $request->nik;
                $payload['name'] = $request->name;
                $payload['email'] = $request->email;
                $payload['whatsapp'] = $request->whatsapp;

                return redirect()->route('index', [
                    'step' => "konfirmasi",
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
                $user = User::firstOrCreate(
                    [
                        'nik' =>  $payload['nik'],
                        'email' =>  $payload['email'],
                    ],
                    [
                        'name' =>  $payload['name'],
                        'whatsapp' =>  $payload['whatsapp'],
                        'password' => bcrypt("default")
                    ]
                );

                // Create Transaction
                $trx = Transaction::create([
                    'user_id' => $user->id,
                    'ticket_id' => $ticketID,
                    'payment_status' => "PENDING",
                    'payment_amount' => $payload['ticket']['price'],
                    'expired_at' => Carbon::now()->addMinutes((int)env('PAYMENT_EXPIRATION'))->format('Y-m-d H:i:s'),
                ]);

                $trx = Transaction::where('id', $trx->id)
                ->with(['ticket', 'user'])
                ->first();

                $payload['transaction'] = $trx;

                Ticket::where('id', $ticketID)->decrement('quantity');

                // DO NOTIF
                if (env('DO_BROADCAST') == 1) {
                    $user->notify(
                        new OrderCreated([
                            'user' => $user,
                            'trx' => $trx,
                        ])
                    );
                }

                return redirect()->route('index', [
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
}
