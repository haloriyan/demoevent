<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RundownSpeaker extends Model
{
    protected $fillable = [
        'rundown_id', 'speaker_id'
    ];

    public function speaker() {
        return $this->belongsTo(Speaker::class, 'speaker_id');
    }
}
