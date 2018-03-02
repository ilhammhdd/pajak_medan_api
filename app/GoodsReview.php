<?php
/**
 * Created by PhpStorm.
 * User: milha
 * Date: 2/27/2018
 * Time: 4:13 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class GoodsReview extends Model
{
    protected $table = 'goods_reviews';

    protected $fillable = [
        'id', 'review_id', 'good_id'
    ];

    public function review()
    {
        return $this->belongsTo('App\Review', 'review_id', 'id');
    }

    public function good()
    {
        {
            return $this->belongsTo('App\Good', 'good_id', 'id');
        }
    }
}