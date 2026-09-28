<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = array(
        'product_id',
        'image_path',
        'sort_order',
    );

    protected $casts = array(
        'sort_order' => 'integer',
    );

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
