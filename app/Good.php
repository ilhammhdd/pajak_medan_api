<?php
/**
 * Created by PhpStorm.
 * User: milha
 * Date: 12/27/2017
 * Time: 8:57 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    protected $table = 'goods';

    protected $fillable = [
        'id', 'file_id', 'category_id', 'name', 'price', 'description', 'available', 'unit', 'min_order', 'condition'
    ];

    public function file()
    {
        return $this->belongsTo('App\File', 'file_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id', 'id');
    }

    public function basket()
    {
        return $this->belongsToMany('App\Basket', 'baskets_goods', 'role_id', 'basket_id');
    }
}