<?php
/**
 * Created by PhpStorm.
 * User: milha
 * Date: 12/27/2017
 * Time: 8:51 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles';

    protected $fillable = [
        'id', 'full_name', 'phone_number', 'email', 'main'
    ];

    public function customer()
    {
        return $this->hasOne('App\Customer', 'profile_id', 'id');
    }

    public function employee()
    {
        return $this->hasOne('App\Employee', 'profile_id', 'id');
    }
}