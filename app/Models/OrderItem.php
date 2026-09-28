<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = array(
        'order_id',
        'product_id',
        'product_name',
        'quantity',
        'price',
        'total',
    );

    protected $casts = array(
        'quantity' => 'integer',
        'price'    => 'decimal:2',
        'total'    => 'decimal:2',
    );

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
