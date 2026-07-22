<?php

namespace App\Services;

use Doku\Snap\Snap;
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

    public function payoutSignature(array $props)
    {
        $mode = strtoupper(env('DOKU_MODE'));

        $body = json_encode($props['body']);

        $bodyHash = hash('sha256', $body); // lowercase hex

        $stringToSign = implode(':', [
            strtoupper($props['method']),      // POST
            $props['endpoint'],                // /payout/v1/transfer
            $props['access_token'],
            $bodyHash,
            $props['timestamp'],
        ]);

        return base64_encode(
            hash_hmac(
                'sha512',
                $stringToSign,
                env('DOKU_SECRET_KEY_'.$mode),
                true
            )
        );
    }
    public function signature($props) {
        $body = $props['body'];
        $mode = strtoupper(env('DOKU_MODE'));
        $clientID = env('DOKU_CLIENT_ID_'.$mode);
        $minifiedBody = json_encode($body);
        $target = "/checkout/v1/payment";

        $signPayload =  "Client-Id:" . $clientID. "\n" .
                        "Request-Id:" . $props['id'] . "\n" .
                        "Request-Timestamp:" . $props['timestamp'] ."\n" .
                        "Request-Target:" . $target . "\n" .
                        "Digest:" . base64_encode(
                            hash('sha256', $minifiedBody, true)
                        );

        $signature = hash_hmac('sha256', $signPayload, env('DOKU_SECRET_KEY_' . $mode), true);

        return base64_encode($signature);
    }

    public function checkout($props) {
        $requestID = (string) Str::uuid();
        $timestamp = now()->utc()->format('Y-m-d\TH:i:s\Z');
        $mode = strtoupper(env('DOKU_MODE'));
        $clientID = env('DOKU_CLIENT_ID_'.$mode);
        
        $body = [
            'client' => [
                'id' => $clientID
            ],
            'order' => [
                'invoice_number' => $props['invoice_number'],
                'amount' => $props['amount'],
                'currency' => 'IDR'
            ],
            'customer' => [
                'name' => escapeName(@$props['customer']['name'] ?? "John Doe"),
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
            'Client-Id' => $clientID,
            'Request-Id' => $requestID,
            'Request-Timestamp' => $timestamp,
            'Signature' => "HMACSHA256=" . $signature,
        ];
        $endpoint = $mode == "LIVE" ? 'https://api.doku.com/checkout/v1/payment' : 'https://api-sandbox.doku.com/checkout/v1/payment';

        $response = Http::withHeaders($headers)
        ->post($endpoint, $body);

        return $response->json();
    }
}