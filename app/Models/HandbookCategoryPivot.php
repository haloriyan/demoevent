<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HandbookCategoryPivot extends Model
{
    protected $fillable = ['handbook_id', 'category_id'];
}
