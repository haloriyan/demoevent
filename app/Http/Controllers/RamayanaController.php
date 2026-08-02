<?php

namespace App\Http\Controllers;

use App\Models\Ramayana;
use App\Services\Doku;
use Illuminate\Http\Request;

class RamayanaController extends Controller
{
    public function purchase(Request $request, Doku $doku) {
        $price = env('RAMAYANA_PRICE');
        $qty = $request->qty;
        $totalPay = $price * $qty;

        $ref = "RMY_" . date('Ymd') . rand(1111, 9999);

        $store = Ramayana::create([
            'ref' => $ref,
            'name' => $request->name,
            'email' => $request->email,
            'price' => $price,
            'quantity' => $qty,
            'total_pay' => $totalPay,

            'payment_status' => "PENDING",
            'payment_payload' => null,
            'payment_link' => null,
        ]);

        $payment = $doku->checkout([
            'invoice_number' => $ref,
            'amount' => $totalPay,
            'customer' => [
                'name' => $request->name,
                'email' => $request->email,
            ],
        ]);
        $payment['order_id'] = $ref;

        $paymentLink = data_get($payment, 'response.payment.url');

        Ramayana::where('id', $store->id)->update([
            'payment_payload' => json_encode($payment),
            'payment_link' => $paymentLink,
        ]);

        return redirect($paymentLink ?: url('/'));
    }
    public function done(Request $request) {
        return view('ramayana.done');
    }
    public function callback(Request $request) {
        $order = $request->order ?? null;
        $orderID = $order['invoice_number'] ?? $request->order_id ?? $request->invoice_number ?? null;

        if ($orderID) {
            $trx = Ramayana::where('ref', $orderID);
            $transaction = $trx->first();

            if ($transaction && $transaction->payment_status != 'PAID') {
                $trx->update([
                    'payment_status' => 'PAID',
                    'payment_payload' => json_encode($request->all()),
                ]);
            }
        }

        return response()->json(['ok']);
    }
}
