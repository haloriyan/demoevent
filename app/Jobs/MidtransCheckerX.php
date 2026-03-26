<?php

namespace App\Jobs;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MidtransCheckerX implements ShouldQueue
{
    use Queueable;

    public $serverKey;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $useCase = "SNAP"; // SNAP / CORE API
        $mode = strtoupper(env('MIDTRANS_MODE'));
        $this->serverKey = env('MIDTRANS_SERVER_KEY_'. $mode);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $transactions = Transaction::where('payment_status', 'PENDING')
        ->where(function ($query) {
            $query->where('last_payment_checking', '<=', Carbon::now()->subMinutes(30))
                ->orWhereNull('last_payment_checking');
        })
        ->orderBy('last_payment_checking', 'ASC')
        ->take(10)->get();
        Log::info($transactions);

        foreach ($transactions as $trx) {
            $payload = json_decode($trx->payment_payload, false);
            $orderID = $payload->order_id;
            Log::info("Checking : " . $orderID);

            $response = Http::withBasicAuth($this->serverKey, '')
            ->get("https://api.sandbox.midtrans.com/v2/".$orderID."/status");

            $data = $response->json();
            
            Transaction::where('id', $trx->id)->update([
                'last_payment_checking' => Carbon::now()->format('Y-m-d H:i:s'),
                'payment_status' => strtoupper($data['transaction_status'])
            ]);
        }
    }
}
