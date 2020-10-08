<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_tag', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('article_id')->unsigned()->comment('投稿ID');
                $table->foreign('article_id')
                    ->references('id')
                    ->on('articles')
                    ->onDelete('cascade');
            $table->bigInteger('tag_id')->unsigned()->comment('タグID');
                $table->foreign('tag_id')
                    ->references('id')
                    ->on('tags')
                    ->onDelete('cascade');
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
        Schema::dropIfExists('article_tag');
    }
}
