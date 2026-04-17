<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    protected $fillable = [
        'category_id', 'ticket_category_id', 'rundown_id', 'title', 'count', 'quantity'
    ];

    public function category() {
        return $this->belongsTo(WsCategory::class, 'category_id');
    }
    public function rundown() {
        return $this->belongsTo(Rundown::class, 'rundown_id');
    }
}
