<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Broadcast extends Model
{
    protected $fillable = [
        'device_id', 'title', 'content', 'image', 'sent', 'total'
    ];

    public function receivers() {
        return $this->belongsToMany(User::class, 'broadcast_receivers');
    }
    public function device() {
        return $this->belongsTo(WaDevice::class, 'device_id');
    }
    public function logs() {
        return $this->hasMany(BroadcastLog::class, 'broadcast_id');
    }
}
