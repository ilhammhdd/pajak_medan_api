<?php
/**
 * Created by PhpStorm.
 * User: milha
 * Date: 3/7/2018
 * Time: 10:15 AM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class CheckoutUnique extends Model
{
    protected $table = 'checkout_uniques';

    protected $fillable = [
        'number', 'used'
    ];

    public function checkout()
    {
        return $this->hasMany('App\Checkout', 'checkout_unique_number', 'number');
    }
}