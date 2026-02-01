<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ScanController extends Controller
{
    public function check(Request $request) {
        $transaction = Transaction::where('id', $request->trx_id)->with(['ticket', 'user'])->first();
        $user = null;

        if ($transaction && $transaction->payment_status == "PAID") {
            $user = $transaction->user;
        }
        
        return response()->json([
            'user' => $user,
        ]);
    }
}
