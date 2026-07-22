<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    protected $fillable = [
        'transaction_id', 'user_id', 'ticket_id', 'bank_name', 'bank_account', 'bank_number',
        'payment_status', 'payment_payload'
    ];

    public function transaction() {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
