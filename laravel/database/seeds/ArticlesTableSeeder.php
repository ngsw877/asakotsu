<?php

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Article;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 60; $i++) {
            $artice = Article::create([
                'user_id'    => User::inRandomOrder()->first()->id,
                'body'       => 'これはテスト投稿です' . $i,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $artice->tags()->attach(Tag::inRandomOrder()->first());
        }
    }
}
