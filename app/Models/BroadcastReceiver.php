<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BroadcastReceiver extends Model
{
    protected $fillable = [
        'broadcast_id', 'user_id', 'status'
    ];
}
