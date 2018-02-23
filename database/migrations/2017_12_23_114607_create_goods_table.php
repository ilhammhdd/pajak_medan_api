<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('file_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->string('name');
            $table->integer('price');
            $table->text('description');
            $table->boolean('available');
            $table->string('unit');
            $table->timestamps();
        });

        Schema::table('goods', function (Blueprint $table) {
            $table->foreign('file_id')->references('id')->on('files');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('goods', function (Blueprint $table) {
            $table->dropForeign('goods_file_id_foreign');
            $table->dropForeign('goods_category_id_foreign');
        });

        Schema::dropIfExists('goods');
    }
}
