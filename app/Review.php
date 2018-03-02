<?php
/**
 * Created by PhpStorm.
 * User: milha
 * Date: 2/27/2018
 * Time: 4:09 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';
    protected $fillable = [
        'id', 'user_id', 'start', 'comment'
    ];

    public function user()
    {
        return $this->belongsTo('App\Users', 'user_id', 'id');
    }

    public function goodsReview()
    {
        return $this->hasOne('App\GoodsReview', 'review_id', 'id');
    }
}