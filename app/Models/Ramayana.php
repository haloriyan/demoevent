<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ramayana extends Model
{
    protected $fillable = [
        'ref', 'name', 'email',
        'quantity', 'price', 'total_pay',
        'payment_status', 'payment_payload', 'payment_link'
    ];
}
