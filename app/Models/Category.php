<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = array(
        'name',
        'slug',
        'description',
        'image',
        'is_active',
        'sort_order',
    );

    protected $casts = array(
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    );

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
}
