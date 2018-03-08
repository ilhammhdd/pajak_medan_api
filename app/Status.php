<?php
/**
 * Created by PhpStorm.
 * User: milha
 * Date: 3/5/2018
 * Time: 9:07 AM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';

    protected $fillable = [
        'id', 'nama'
    ];

    public function basket()
    {
        return $this->hasMany('App\Basket', 'status_id', 'id');
    }

    public function checkout()
    {
        return $this->hasMany('App\Checkout', 'status_id', 'id');
    }
}