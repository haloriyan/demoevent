<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Illuminate\Support\Str;

class Doku {
    public $config;

    public function __construct()
    {
        $this->config = config('doku');
    }

    public function signature($props) {
        $clientID = $this->config['client_id'];
        $body = $props['body'];
        // $this->ksortRecursive($body);
        $minifiedBody = json_encode($body);
        $target = "/checkout/v1/payment";

        $signPayload =  "Client-Id:" . $clientID. "\n" .
                        "Request-Id:" . $props['id'] . "\n" .
                        "Request-Timestamp:" . $props['timestamp'] ."\n" .
                        "Request-Target:" . $target . "\n" .
                        "Digest:" . base64_encode(
                            hash('sha256', $minifiedBody, true)
                        );

        $signature = hash_hmac('sha256', $signPayload, $this->config['secret_key'], true);

        return base64_encode($signature);
    }

    public function checkout($props) {
        $requestID = (string) Str::uuid();
        $timestamp = now()->utc()->format('Y-m-d\TH:i:s\Z');
        $mode = strtolower(env('DOKU_MODE'));
        
        $body = [
            'client' => [
                'id' => $this->config['client_id']
            ],
            'order' => [
                'invoice_number' => $props['invoice_number'],
                'amount' => $props['amount'],
                'currency' => 'IDR'
            ],
            'customer' => [
                'name' => @$props['customer']['name'] ?? "John Doe",
                'email' => @$props['customer']['email'] ?? 'john@example.com'
            ],
            'payment' => [
                'type' => 'SALE'
            ]
        ];

        $signature = $this->signature([
            'timestamp' => $timestamp,
            'body' => $body,
            'id' => $requestID,
        ]);

        $headers = [
            'Client-Id' => $this->config['client_id'],
            'Request-Id' => $requestID,
            'Request-Timestamp' => $timestamp,
            'Signature' => "HMACSHA256=" . $signature,
        ];
        $endpoint = $mode == "live" ? 'https://api.doku.com/checkout/v1/payment' : 'https://api-sandbox.doku.com/checkout/v1/payment';

        $response = Http::withHeaders($headers)
        ->post($endpoint, $body);

        return $response->json();
    }
}