<?php
/**
 * Created by PhpStorm.
 * User: milha
 * Date: 12/27/2017
 * Time: 9:07 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    protected $table = 'checkouts';

    public $timestamps = false;

    protected $fillable = [
        'id', 'basket_id', 'payment_id', 'status_id', 'expired', 'issued'
    ];

    public function basket()
    {
        return $this->belongsTo('App\Basket', 'basket_id', 'id');
    }

    public function payment()
    {
        return $this->belongsTo('App\Payment', 'payment_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Status', 'status_id', 'id');
    }

    public function checkoutUnique()
    {
        return $this->belongsTo('App\CheckoutUnique', 'checkout_unique_number', 'number');
    }
}