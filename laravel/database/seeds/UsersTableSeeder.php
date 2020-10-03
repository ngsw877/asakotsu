<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
            'name' => 'ゲストユーザー',
            'email' => 'guest@guest.com',
            'password' => Hash::make(config('user.user_password_01')),
            'profile_image' => 'default.png',
            ],
            [
            'name' => '山田',
            'email' => 'yamada@co.jp',
            'password' => Hash::make(config('user.user_password_02')),
            'profile_image' => 'sun.gif',
            ],
            [
            'name' => 'suzuki',
            'email' => 'suzuki@co.jp',
            'password' => Hash::make(config('user.user_password_03')),
            'profile_image' => 'cat.jpg',
            ],
        ]);
    }
}
