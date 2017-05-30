<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBadgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('badges', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('勋章名字');
            $table->string('desc')->comment('勋章描述');
            $table->string('image')->comment('勋章图片');
            $table->timestamps();
        });

        Schema::create('user_badge', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('badge_id');
            $table->primary(['user_id','badge_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('badges');
        Schema::dropIfExists('user_badge');
    }
}
