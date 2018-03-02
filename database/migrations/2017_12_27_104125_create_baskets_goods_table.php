<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBasketsGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baskets_goods', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('good_id')->unsigned();
            $table->integer('basket_id')->unsigned();
            $table->integer('good_quantity');
            $table->integer('total_price');
        });

        Schema::table('baskets_goods', function (Blueprint $table) {
            $table->foreign('good_id')->references('id')->on('goods');
            $table->foreign('basket_id')->references('id')->on('baskets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('baskets_goods', function (Blueprint $table) {
            $table->dropForeign('baskets_goods_good_id_foreign');
            $table->dropForeign('baskets_goods_basket_id_foreign');
        });

        Schema::dropIfExists('baskets_goods');
    }
}
