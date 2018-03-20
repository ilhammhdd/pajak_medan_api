<?php
/**
 * Created by PhpStorm.
 * User: milha
 * Date: 3/1/2018
 * Time: 3:21 AM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class BasketGoods extends Model
{
    protected $table = 'baskets_goods';

    protected $fillable = [
        'id', 'good_id', 'basket_id', 'good_quantity', 'total_price'
    ];

    public $timestamps = false;

    public function basket()
    {
        return $this->belongsTo('App\Basket', 'basket_id', 'id');
    }
}