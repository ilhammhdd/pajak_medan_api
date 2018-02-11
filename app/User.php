<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'role_id', 'file_id', 'email', 'username', 'api_token'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function role()
    {
        return $this->belongsTo('App\Role', 'role_id', 'id');
    }

    public function loginType()
    {
        return $this->belongsTo('App\LoginType', 'login_type_id', 'id');
    }

    public function employee()
    {
        return $this->hasOne('App\Employee', 'user_id', 'id');
    }

    public function customer()
    {
        return $this->hasOne('App\Customer', 'user_id', 'id');
    }

    public function file()
    {
        return $this->belongsTo('App\File', 'file_id', 'id');
    }
}
