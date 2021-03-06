<?php
/**
 * Created by PhpStorm.
 * User: milha
 * Date: 12/27/2017
 * Time: 9:03 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    protected $table = 'baskets';

    public $timestamps = false;

    protected $fillable = [
        'id', 'customer_id', 'total', 'total_items', 'description', 'status_id'
    ];

    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id', 'id');
    }

    public function checkout()
    {
        return $this->hasOne('App\Checkout', 'basket_id', 'id');
    }

    public function nightOrder()
    {
        return $this->hasOne('App\NightOrder', 'basket_id', 'id');
    }

    public function good()
    {
        return $this->belongsToMany('App\Good', 'baskets_goods', 'basket_id', 'good_id');
    }

    public function basketGood()
    {
        return $this->hasMany('App\BasketGoods', 'basket_id', 'id');
    }

    public function status()
    {
        return $this->belongTo('App\Status', 'status_id', 'id');
    }
}