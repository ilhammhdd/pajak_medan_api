<?php
/**
 * Created by PhpStorm.
 * User: milha
 * Date: 2/15/2018
 * Time: 5:45 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    protected $fillable = [
        'id', 'file_path', 'file_name'
    ];

    public function file()
    {
        return $this->belongsTo('App\File', 'file_id', 'id');
    }
}