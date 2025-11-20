<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Notifications\PaymentConfirmed;
use Illuminate\Http\Request;

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
            $transaction->user->notify(new PaymentConfirmed([
                'trx' => $transaction,
            ]));
        }

        return redirect()->back()->with([
            'message' => "Berhasil mengkonfirmasi pembayaran #" . $transaction->id,
        ]);
    }
}
