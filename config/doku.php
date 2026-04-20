<?php

return [
    'mode' => env('DOKU_MODE'),
    'secret_key' => env("DOKU_SECRET_KEY"),
    'api_key' => env("DOKU_API_KEY"),
    'public_key' => env('DOKU_PUBLIC_KEY'),
    'private_key' => file_get_contents(storage_path('doku/pv.key')),
    'passphrase' => env('DOKU_PASSPHRASE'),
    'client_id' => env('DOKU_CLIENT_ID'),
];