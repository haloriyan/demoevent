<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaDevice extends Model
{
    protected $fillable = [
        'client_id', 'name', 'number', 'profile_picture', 'is_primary'
    ];
}
