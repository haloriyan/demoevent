<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'ticket_id',
        'payment_amount', 'payment_status', 'payment_payload', 'payment_evidence', 'expired_at',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function ticket() {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}
