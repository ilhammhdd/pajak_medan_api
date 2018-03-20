<?php
/**
 * Created by PhpStorm.
 * User: milha
 * Date: 3/16/2018
 * Time: 5:13 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';

    protected $fillable = [
        'id', 'customer_id', 'name', 'main'
    ];

    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id', 'id');
    }
}