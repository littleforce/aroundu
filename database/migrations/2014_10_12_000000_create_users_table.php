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
            $table->string('name')->comment('昵称');
            $table->string('email')->unique()->comment('email');
            $table->string('password')->comment('密码');
            $table->string('avatar')->comment('头像')->nullable();
            $table->integer('level')->comment('权限等级')->default(0);
            $table->integer('effect')->comment('影响力')->default(0);
            $table->bigInteger('experience')->comment('经验')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
