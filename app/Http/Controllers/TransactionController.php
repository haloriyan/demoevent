<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\WaDevice;
use App\Notifications\PaymentConfirmed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TransactionController extends Controller
{
    public function confirmByAdmin(Request $request, $id) {
        $trx = Transaction::where('id', $id);
        $transaction = $trx->with(['user', 'ticket'])->first();

        $toUpdate = [
            'payment_status' => "PAID"
        ];

        if ($transaction->payment_evidence == null) {
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

            $device = WaDevice::where('is_primary', true)->first();
            Http::post(env('WA_URL') . "/send", [
                'client_id' => $device->client_id,
                'destination' => "62".$user->whatsapp,
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
            'message' => "Berhasil mengkonfirmasi pembayaran #" . $transaction->id,
        ]);
    }
}
