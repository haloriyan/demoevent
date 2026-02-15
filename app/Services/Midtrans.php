<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Midtrans {
    public $baseURL;
    public $serverKey;

    public function __construct()
    {
        $useCase = "SNAP"; // SNAP / CORE API
        $mode = strtoupper(env('MIDTRANS_MODE'));
        $this->serverKey = env('MIDTRANS_SERVER_KEY_'. $mode);
        $this->baseURL = $mode == "SANDBOX" ? 
            "https://app.sandbox.midtrans.com/snap/v1/transactions" :
            "https://app.midtrans.com/snap/v1/transactions";
    }

    public function snap($payload) {
        $body = [
            'transaction_details' => $payload['transaction']
        ];
        if (isset($payload['items'])) {
            $body['item_details'] = $payload['items'];
        }
        if (isset($payload['customer'])) {
            $body['customer_details'] = $payload['customer'];
        }

        $headers = [
            'X-Append-Notification' => request()->getSchemeAndHttpHost() . "/api/callback/midtrans"
        ];

        $response = Http::withBasicAuth($this->serverKey, '')
        ->withHeaders($headers)
        ->post(
            $this->baseURL, $body
        );

        return $response->json();
    }
}