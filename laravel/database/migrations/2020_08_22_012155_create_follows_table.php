<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('follower_id')
                ->unsigned()->comment('フォロワーID');
                $table->foreign('follower_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
            $table->bigInteger('followee_id')
                ->unsigned()->comment('フォロー中のユーザーID');
                $table->foreign('followee_id')
                    ->references('id')
                    ->on('users')
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
        Schema::dropIfExists('follows');
    }
}
