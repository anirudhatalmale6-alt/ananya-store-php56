<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = array(
        'cart_id',
        'product_id',
        'quantity',
    );

    protected $casts = array(
        'quantity' => 'integer',
    );

    public function cart()
    {
        return $this->belongsTo('App\Models\Cart');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
