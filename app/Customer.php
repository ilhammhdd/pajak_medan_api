<?php
/**
 * Created by PhpStorm.
 * User: milha
 * Date: 12/27/2017
 * Time: 8:50 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        'id', 'user_id', 'profile_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function profile()
    {
        return $this->belongsTo('App\profile', 'profile_id', 'id');
    }

    public function basket()
    {
        return $this->hasOne('App\Basket', 'customer_id', 'id');
    }

    public function address()
    {
        return $this->hasMany('App\Address', 'customer_id', 'id');
    }
}