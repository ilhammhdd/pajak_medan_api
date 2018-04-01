<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('basket_id')->unsigned();
            $table->integer('payment_id')->unsigned();
            $table->integer('status_id')->unsigned();
            $table->dateTime('expired');
        });

        Schema::table('checkouts', function (Blueprint $table) {
            $table->foreign('basket_id')->references('id')->on('baskets');
            $table->foreign('payment_id')->references('id')->on('payments');
            $table->foreign('status_id')->references('id')->on('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('checkouts', function (Blueprint $table) {
            $table->dropForeign('checkouts_basket_id_foreign');
            $table->dropForeign('checkouts_payment_id_foreign');
            $table->dropForeign('checkouts_status_id_foreign');
        });

        Schema::dropIfExists('checkouts');
    }
}
