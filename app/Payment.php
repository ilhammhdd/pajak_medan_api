<?php
/**
 * Created by PhpStorm.
 * User: milha
 * Date: 3/3/2018
 * Time: 8:40 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'id', 'file_id', 'name', 'detail'
    ];

    public function checkout()
    {
        return $this->hasMany('App\Checkout', 'payment_id', 'id');
    }

    public function file()
    {
        return $this->belongsTo('App\File', 'file_id', 'id');
    }
}