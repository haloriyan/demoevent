<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoothCheckin extends Model
{
    protected $fillable = [
        'booth_id', 'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function booth() {
        return $this->belongsTo(Booth::class, 'booth_id');
    }
}
