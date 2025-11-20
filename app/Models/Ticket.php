<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'category_id',
        'name', 'price', 'start_date', 'end_date',
        'start_quantity', 'quantity', 'visible',
    ];
}
