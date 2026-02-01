<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\WaDevice;
use App\Notifications\PaymentConfirmed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
            $user->notify(new PaymentConfirmed([
                'trx' => $transaction,
            ]));

            $qrString = base64_encode(json_encode([
                'trx_id' => $transaction->id,
                'user_id' => $user->id,
            ]));
            $qrLink = "https://api.qrserver.com/v1/create-qr-code/?data=$qrString&size=256x256";
            Log::info($qrLink);

            $device = WaDevice::where('is_primary', true)->first();
            Http::post(env('WA_URL') . "/send", [
                'client_id' => $device->client_id,
                'destination' => "62".$user->whatsapp,
                'image' => $qrLink,
                'message' => "Yth. " . $user->name . "\n\n" .
                                'Kami ingin mengkonfirmasi bahwa pembayaran Anda untuk Pertemuan Ilmiah Tahunan Perkumpulan Subspesialis Radiologi Muskuloskeletal Indonesia (PIT PERAMI) telah berhasil.'.
                                'Sebagai bukti transaksi, kami lampirkan kode QR yang akan digunakan saat registrasi ulang di lokasi acara. Mohon simpan kode QR ini dengan baik dan tunjukkan kepada petugas registrasi saat kedatangan.'.
                                "Jika Anda memiliki pertanyaan atau memerlukan bantuan, jangan ragu untuk menghubungi kami di " . env("EMAIL") . " atau " . env("PHONE") . ".\n\n" .
                                "Terima kasih atas partisipasi Anda\n\n".
                                "Hormat Kami,\n ".
                                "Panitia PIT PERAMI"
            ]);
        }

        return redirect()->back()->with([
            'message' => $message,
        ]);
    }
}
