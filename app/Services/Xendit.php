<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Xendit {
    protected $secretKey;
    protected $publicKey;
    protected $mode;
    protected $baseURL;

    public function __construct()
    {
        $mode = env('XENDIT_MODE');
        
        $this->mode = "LIVE";
        $this->baseURL = "https://api.xendit.co";
        $this->publicKey = env('XENDIT_PUBLIC_' . strtoupper($mode));
        $this->secretKey = env('XENDIT_SECRET_' . strtoupper($mode));
    }

    public function pay() {
        Log::info($this->mode);
        $response = Http::withBasicAuth($this->secretKey, '')
        ->withHeaders([
            'api-version' => "2024-11-11"
        ])
        ->post($this->baseURL . "/callback_virtual_accounts", [
            'reference_id' => "PAY_123",
            'external_id' => "HEHE123",
            'country' => "ID",
            'currency' => "IDR",
            'bank_code' => "MANDIRI",
            'name' => "Surabaya Creative Design",
            'request_amount' => 10000,
        ]);

        return $response->body();
    }
}