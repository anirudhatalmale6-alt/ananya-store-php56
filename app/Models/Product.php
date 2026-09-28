<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = array(
        'category_id',
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'sale_price',
        'stock',
        'sku',
        'thumbnail',
        'weight',
        'is_active',
        'is_featured',
    );

    protected $appends = array('current_price');

    protected $casts = array(
        'price'       => 'decimal:2',
        'sale_price'  => 'decimal:2',
        'weight'      => 'decimal:2',
        'stock'       => 'integer',
        'is_active'   => 'boolean',
        'is_featured' => 'boolean',
    );

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function productImages()
    {
        return $this->hasMany('App\Models\ProductImage');
    }

    public function orderItems()
    {
        return $this->hasMany('App\Models\OrderItem');
    }

    public function cartItems()
    {
        return $this->hasMany('App\Models\CartItem');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Sale price when one is set, otherwise the regular price.
     * Replaces the Laravel 9+ Attribute::make() accessor.
     *
     * @return float
     */
    public function getCurrentPriceAttribute()
    {
        $sale = $this->sale_price;

        if ($sale !== null && $sale !== '' && (float) $sale > 0) {
            return $sale;
        }

        return $this->price;
    }
}
