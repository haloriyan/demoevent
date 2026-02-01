<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scan extends Model
{
    protected $fillable = [
        'user_id', 'ticket_id', 'transaction_id', 'booth_id'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function transaction() {
        return $this->belongsTo(Ticket::class, 'transaction_id');
    }
    public function ticket() {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}
