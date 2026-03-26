<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Handbook extends Model
{
    protected $fillable = [
        'booth_id', 'kiosk',
        'title', 'filename', 'size'
    ];

    public function categories() {
        // return $this->belongsToMany(HandbookCategory::class, 'handbook_category_pivots');
        return $this->belongsToMany(
            HandbookCategory::class,
            'handbook_category_pivots',
            'handbook_id',     // FK ke handbook
            'category_id'      // FK ke category
        );

    }
}
