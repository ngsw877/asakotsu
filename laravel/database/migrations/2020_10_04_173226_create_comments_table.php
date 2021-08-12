<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->comment('ユーザーID');
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('article_id')->unsigned()->comment('投稿ID');
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->string('comment')->comment('コメント');
            $table->ipAddress('ip_address')->nullable()->comment('IPアドレス');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
