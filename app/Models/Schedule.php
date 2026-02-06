<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'title', 'description', 'date'
    ];

    public function rundowns() {
        return $this->hasMany(Rundown::class, 'schedule_id');
    }
}
