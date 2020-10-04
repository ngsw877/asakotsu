<?php

use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentsTableSeeder extends Seeder
{
    // ユーザID 1 のユーザが各ユーザに1つコメントしておく
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            Comment::create([
                'user_id' => 1,
                'article_id' => $i,
                'comment' => 'これはテストコメントです。' .$i,
                'created_at' => now()
            ]);
        }
    }
}
