<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title' ,512);
            $table->string('link')->unique();
            $table->string('domain');
            $table->string('featured_image' , 1024);
            $table->string('category');
            $table->longText('description');
            $table->string('tags');
            $table->string('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('username');
            $table->bigInteger('views');
            $table->bigInteger('post_votes');
            $table->bigInteger('post_comments');
            $table->integer('is_link');
            $table->integer('is_image');
            $table->integer('is_video');
            $table->integer('is_article');
            $table->integer('is_list');
            $table->integer('is_poll');
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
        Schema::dropIfExists('posts');
    }
}
