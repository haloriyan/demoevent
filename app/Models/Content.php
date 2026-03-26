<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $fillable = [
        'title', 'cover', 'description', 'level', 'language', 'photographer', 'photographer_url'
    ];

    public function slides() {
        return $this->hasMany(ContentSlide::class, 'content_id');
    }
    public function subjects() {
        return $this->hasMany(ContentSubject::class, 'content_id');
    }
}
