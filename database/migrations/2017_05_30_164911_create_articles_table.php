<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('发布者');
            $table->integer('type')->comment('1长文、2短文');
            $table->string('title')->comment('文章标题');
            $table->string('image')->comment('文章图片')->nullable();
            $table->text('content')->comment('文章内容');
            $table->json('location')->comment('文章发表位置');
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
        Schema::dropIfExists('articles');
    }
}
