<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LikesTableSeeder extends Seeder
{
    // ユーザID 1 が、自分を除くツイートに対して1ついいねを付ける
    public function run()
    {
        for($i = 2; $i <= 10; $i++) {
            DB::table('likes')->insert([
                'user_id' => 1,
                'article_id' => $i
                ]);
            }
    }
}
