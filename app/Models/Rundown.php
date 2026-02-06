<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rundown extends Model
{
    protected $fillable = [
        'schedule_id', 'title', 'description', 'start_time', 'end_time'
    ];

    public function speakers() {
        return $this->belongsToMany(Speaker::class, 'rundown_speakers');
    }
}
