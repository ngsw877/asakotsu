<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentsTableSeeder extends Seeder
{
    // ユーザID 1 のユーザが各ユーザに1つコメントしておく
    public function run()
    {
        // 投稿10件に対して
        for ($i = 1; $i <= 10; $i++) {

            // コメントを25件ずつ登録
            for ($j = 1; $j <= 25; $j++) {
                Comment::create([
                    'user_id'    => User::inRandomOrder()->first()->id,
                    'article_id' => $i,
                    'comment'    => 'これはテストコメントです。' . $j,
                    'created_at' => now()
                ]);
            }
        }
    }
}
