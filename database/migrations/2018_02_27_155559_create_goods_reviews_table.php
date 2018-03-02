<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('review_id')->unsigned();
            $table->integer('good_id')->unsigned();
        });

        Schema::table('goods_reviews', function (Blueprint $table) {
            $table->foreign('review_id')->references('id')->on('reviews');
            $table->foreign('good_id')->references('id')->on('goods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('goods_reviews', function (Blueprint $table) {
            $table->dropForeign('goods_reviews_review_id_foreign');
            $table->dropForeign('goods_reviews_good_id_foreign');
        });

        Schema::dropIfExists('goods_reviews');
    }
}
