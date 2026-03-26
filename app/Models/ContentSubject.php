<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentSubject extends Model
{
    protected $fillable = [
        'content_id', 'subject'
    ];
}
