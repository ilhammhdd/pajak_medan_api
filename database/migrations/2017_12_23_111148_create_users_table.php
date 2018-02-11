<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned();
            $table->integer('login_type_id')->unsigned();
            $table->integer('file_id')->nullable()->unsigned();
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('api_token');
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('login_type_id')->references('id')->on('login_types');
            $table->foreign('file_id')->references('id')->on('files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_role_id_foreign');
            $table->dropForeign('users_login_type_id_foreign');
            $table->dropForeign('users_file_id_foreign');
        });

        Schema::dropIfExists('users');
    }
}
