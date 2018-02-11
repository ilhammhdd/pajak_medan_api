<?php
/**
 * Created by PhpStorm.
 * User: milha
 * Date: 2/5/2018
 * Time: 6:55 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class LoginType extends Model
{
    protected $table = 'login_types';

    protected $fillable = [
        'id', 'name'
    ];

    public function user()
    {
        return $this->hasMany('App\User', 'login_type_id', 'id');
    }
}