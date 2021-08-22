<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(ArticlesTableSeeder::class);
        $this->call(MeetingsTableSeeder::class);
        $this->call(LikesTableSeeder::class);
        $this->call(FollowsTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
    }
}
