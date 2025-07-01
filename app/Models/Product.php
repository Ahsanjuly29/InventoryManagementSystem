<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'buying_price',
        'quantity',
        'sell_price',
        'total',
    ];
}
