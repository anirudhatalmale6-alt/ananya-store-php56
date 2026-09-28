<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array(
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'city',
        'state',
        'zip',
        'country',
    );

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = array(
        'password',
        'remember_token',
    );

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = array(
        'email_verified_at' => 'datetime',
    );

    /**
     * @var array
     */
    protected $dates = array('email_verified_at');

    /**
     * Always store passwords hashed. Replaces Laravel 11+ 'hashed' cast,
     * which does not exist in Laravel 5.4.
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        if ($value === null || $value === '') {
            return;
        }

        // Do not double-hash an already-hashed value.
        $info = password_get_info($value);
        if (isset($info['algo']) && $info['algo']) {
            $this->attributes['password'] = $value;
            return;
        }

        $this->attributes['password'] = bcrypt($value);
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function cart()
    {
        return $this->hasOne('App\Models\Cart');
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
