<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FollowsTableSeeder extends Seeder
{

    public function run()
    {
        // ユーザID 1 が、各ユーザをフォローしておく
        for($i = 2; $i <= 10; $i++) {
            DB::table('follows')->insert([
                'followee_id' => $i,
                'follower_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // ユーザID 1 を、ユーザID 2,3 以外がフォローしておく
        for($i = 4; $i <= 10; $i++) {
            DB::table('follows')->insert([
                'followee_id' => 1,
                'follower_id' => $i,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
