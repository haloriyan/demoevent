<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scan extends Model
{
    protected $fillable = [
        'user_id', 'ticket_id', 'transaction_id', 'booth_id'
    ];
}
