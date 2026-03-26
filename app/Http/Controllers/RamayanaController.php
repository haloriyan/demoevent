<?php

namespace App\Http\Controllers;

use App\Models\Ramayana;
use App\Services\Midtrans;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RamayanaController extends Controller
{
    public $midtrans;

    public function __construct(Midtrans $midtrans)
    {
        $this->midtrans = $midtrans;
    }

    public function purchase(Request $request) {
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

        $names = explode(" ", $request->name);

        $midtrans = $this->midtrans->snap([
            'transaction' => [
                'order_id' => $ref,
                'gross_amount' => $totalPay,
            ],
            'customer' => [
                'first_name' => $names[0],
                'last_name' => @$names[count($names) - 1] ?? "",
                'email' => $request->email,
            ],
        ]);
        $midtrans['order_id'] = $ref;

        $trx = Ramayana::where('id', $store->id);
        $trx->update([
            'payment_payload' => json_encode($midtrans)
        ]);

        $transaction = $trx->first();

        return redirect($midtrans['redirect_url']);
    }
    public function done(Request $request) {
        return view('ramayana.done');
    }
    public function callback(Request $request) {
        $orderID = $request->order_id;

        $order = Ramayana::where('ref', $orderID)->first();

        return response()->json(['ok']);
    }
}
