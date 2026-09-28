<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = array(
        'user_id',
        'session_id',
    );

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function cartItems()
    {
        return $this->hasMany('App\Models\CartItem');
    }
}
