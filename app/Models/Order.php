<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = array(
        'order_number',
        'user_id',
        'status',
        'subtotal',
        'tax',
        'shipping_cost',
        'total',
        'shipping_name',
        'shipping_email',
        'shipping_phone',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_zip',
        'shipping_country',
        'payment_method',
        'payment_status',
        'notes',
    );

    protected $casts = array(
        'subtotal'      => 'decimal:2',
        'tax'           => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total'         => 'decimal:2',
    );

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $latest = static::query()->orderBy('id', 'desc')->value('id');
                if ($latest === null) {
                    $latest = 0;
                }
                $order->order_number = 'ANZ-' . str_pad($latest + 1043, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function orderItems()
    {
        return $this->hasMany('App\Models\OrderItem');
    }
}
