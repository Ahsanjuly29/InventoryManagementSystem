<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'product_id',
        'customer_id',
        'quantity',
        'sell_price',
        'discount',
        'vat',
        'total',
        'customer_paid_amount',
        'due'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
