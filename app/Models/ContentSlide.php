<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentSlide extends Model
{
    protected $fillable = [
        'content_id', 'title', 'body', 'cover'
    ];
}
