<?php

namespace App\Http\Controllers;

use App\Mail\OrderCreated as MailOrderCreated;
use App\Mail\PaymentConfirmed as MailPaymentConfirmed;
use App\Models\Refund;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Workshop;
use App\Models\WaDevice;
use App\Notifications\PaymentConfirmed;
use App\Notifications\TransactionCancelled;
use App\Services\Doku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TransactionController extends Controller
{
    public function confirmByAdmin(Request $request, $id) {
        $trx = Transaction::where('id', $id);
        $transaction = $trx->with(['user', 'ticket'])->first();
        $message = "Berhasil mengkonfirmasi pembayaran #" . $transaction->id;

        if ($request->is_resend == "y") {
            $message = "Berhasil mengirim ulang konfirmasi pembayaran dan Kode QR";
        }

        $toUpdate = [
            'payment_status' => "PAID"
        ];

        if ($transaction->payment_evidence == null && $request->hasFile('evidence')) {
            $evidence = $request->file('evidence');
            $fileName = time()."_".$evidence->getClientOriginalName();
            $evidence->move(
                public_path('storage/payment_evidences'),
                $fileName
            );
            $toUpdate['payment_evidence'] = $fileName;
        }

        $trx->update($toUpdate);

        if (env('DO_BROADCAST') == 1) {
            $user = $transaction->user;
            Mail::to($user->email)->send(new MailPaymentConfirmed([
                'trx' => $transaction
            ]));

            $qrString = base64_encode(json_encode([
                'trx_id' => $transaction->id,
                'user_id' => $user->id,
            ]));
            $qrLink = "https://api.qrserver.com/v1/create-qr-code/?data=$qrString&size=256x256";

            $device = WaDevice::where('is_primary', true)->first();
            if ($device != null) {
                Http::post(env('WA_URL') . "/send", [
                    'client_id' => $device->client_id,
                    'destination' => "62".$user->whatsapp,
                    'image' => $qrLink,
                    'message' => "Yth. " . $user->name . "\n\n" .
                                    'Kami ingin mengkonfirmasi bahwa pembayaran Anda untuk PIT PERABDIN - ASAR ELC 2026 telah berhasil.'.
                                    'Sebagai bukti transaksi, kami lampirkan kode QR yang akan digunakan saat registrasi ulang di lokasi acara. Mohon simpan kode QR ini dengan baik dan tunjukkan kepada petugas registrasi saat kedatangan.'.
                                    "Jika Anda memiliki pertanyaan atau memerlukan bantuan, jangan ragu untuk menghubungi kami di " . env("EMAIL") . " atau kontak WhatsApp ini.\n\n" .
                                    "Terima kasih atas partisipasi Anda\n\n".
                                    "Hormat Kami,\n ".
                                    "Panitia PIT PERABDIN - ASAR ELC 2026"
                ]);
            }
        }

        return redirect()->back()->with([
            'message' => $message,
        ]);
    }

    // public function
    public function cancelByAdmin(Request $request, Doku $doku, $id) {
        $trx = Transaction::where('id', $id)->with(['user', 'ticket'])->first();
        if (!$trx) {
            return redirect()->back()->withErrors(['Transaksi tidak ditemukan.']);
        }

        $user = $trx->user;
        $ticket = $trx->ticket;

        DB::beginTransaction();
        try {
            $toUpdate = ['payment_status' => 'CANCELLED'];
            if ($trx->payment_status == "PAID") {
                $refund = Refund::create([
                    'transaction_id' => $trx->id,
                    'user_id' => $trx->user_id,
                    'ticket_id' => $trx->ticket_id,
                    'bank_name' => $request->bank_name,
                    'bank_account' => $request->bank_account,
                    'bank_number' => $request->bank_number,
                    'payment_status' => "PENDING",
                ]);
                $toUpdate['refund_id'] = $refund->id;
            }
            
            $trx->update($toUpdate);
            $ticket->increment('quantity');

            $workshops = json_decode($trx->workshops, true);
            if ($workshops) {
                foreach ($workshops as $wsData) {
                    $workshop = Workshop::where('id', $wsData['id'])->first();
                    if ($workshop) {
                        $workshop->decrement('count');
                        $workshop->increment('quantity');
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['Terjadi kesalahan saat membatalkan transaksi. ' . $e->getMessage()]);
        }

        if (env('DO_BROADCAST') == 1) {
            $user->notify(new TransactionCancelled([
                'user' => $user,
                'trx' => $trx,
            ]));
        }

        return redirect()->back()->with([
            'message' => "Berhasil membatalkan transaksi #" . $trx->id,
        ]);
    }

    public function resendOrderConfirmation(Request $request, $id) {
        $trx = Transaction::where('id', $id)->with(['user', 'ticket'])->first();
        if (!$trx) {
            return redirect()->back()->withErrors(['Transaksi tidak ditemukan.']);
        }

        $user = $trx->user;

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

        return redirect()->back()->with([
            'message' => "Berhasil mengirim ulang konfirmasi pendaftaran kepada " . $user->name,
        ]);
    }
}
