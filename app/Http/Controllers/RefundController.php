<?php

namespace App\Http\Controllers;

use App\Models\Refund;
use App\Models\User;
use App\Models\WaDevice;
use App\Notifications\RefundPaid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RefundController extends Controller
{
    public function index(Request $request) {
        $me = me('admin');
        $message = session('message');
        $query = Refund::with(['user', 'transaction.ticket']);

        if ($request->q != "") {
            $query = $query->where(function ($sub) use ($request) {
                $sub->whereHas('user', function ($q) use ($request) {
                    $q->where('name', 'LIKE', "%".$request->q."%");
                })->orWhere('id', $request->q)
                  ->orWhere('bank_name', 'LIKE', "%".$request->q."%")
                  ->orWhere('bank_account', 'LIKE', "%".$request->q."%")
                  ->orWhere('bank_number', 'LIKE', "%".$request->q."%");
            });
        }

        if ($request->payment_status != "") {
            $query = $query->where('payment_status', $request->payment_status);
        }

        $refunds = $query->orderBy('created_at', 'DESC')->paginate(20);

        return view('admin.refund.index', [
            'refunds' => $refunds,
            'request' => $request,
            'me' => $me,
            'message' => $message,
        ]);
    }

    public function confirm(Request $request, $id) {
        $refund = Refund::findOrFail($id);
        $user = User::where('id', $refund->user_id)->first();

        $toUpdate = [
            'payment_status' => "PAID"
        ];

        if ($request->hasFile('evidence')) {
            $evidence = $request->file('evidence');
            $fileName = time()."_".$evidence->getClientOriginalName();
            $evidence->move(
                public_path('storage/refund_evidences'),
                $fileName
            );
            $toUpdate['payment_payload'] = $fileName;
        }

        $refund->update($toUpdate);

        if (env('DO_BROADCAST') == 1) {
            $device = WaDevice::where('is_primary', true)->first();
            $user->notify(new RefundPaid([
                'user' => $user,
                'refund' => $refund,
            ]));

            if ($device) {
                Http::post(env('WA_URL') . "/send", [
                    'client_id' => $device->client_id,
                    'destination' => "62".$user->whatsapp,
                    'image' => env('APP_URL') . '/storage/refund_evidences/' . $refund->payment_payload,
                    'message' => "Yth. " . $user->name . "\n\n" .
                                    "Kami ingin memberitahu bahwa permintaan pembatalan Anda telah sepenuhnya berhasil dan dana telah dikembalikan ke rekening sesuai permintaan.\n\n".
                                    "Jika Anda memiliki pertanyaan atau memerlukan bantuan, jangan ragu untuk menghubungi kami di " . env("EMAIL") . " atau " . env("PHONE") . ".\n\n" .
                                    "Terima kasih atas partisipasi Anda\n\n".
                                    "Hormat Kami,\n ".
                                    "Panitia PIT PERABDIN - ASAR ELC 2026"
                ]);
            }
        }

        return redirect()->back()->with([
            'message' => "Berhasil mengkonfirmasi refund #" . $refund->id,
        ]);
    }
}
