<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WsCategory extends Model
{
    public function workshops() {
        return $this->hasMany(Workshop::class, 'category_id');
    }
}
