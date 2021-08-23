<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
                'name'           => config('user.guest_user.name'),
                'email'          => config('user.guest_user.email'),
                'password'       => Hash::make(config('user.guest_user.password')),
                'profile_image'  => asset(config('user.guest_user.profile_image_path')),
                'remember_token' => Str::random(10),
                'created_at'     => now(),
                'updated_at'     => now(),
            ],

            [
                'name'           => '山田',
                'email'          => 'yamada@example.jp',
                'password'       => Hash::make(config('12345678')),
                'profile_image'  => asset(config('user.profile_image_path.boy')),
                'remember_token' => Str::random(10),
                'created_at'     => now(),
                'updated_at'     => now(),
            ],

            [
                'name'           => 'suzuki',
                'email'          => 'suzuki@example.jp',
                'password'       => Hash::make(config('12345678')),
                'profile_image'  => asset(config('user.profile_image_path.girl')),
                'remember_token' => Str::random(10),
                'created_at'     => now(),
                'updated_at'     => now(),
            ],

            [
                'name'           => 'サン',
                'email'          => 'sun@example.jp',
                'password'       => Hash::make(config('12345678')),
                'profile_image'  => asset(config('user.profile_image_path.sun')),
                'remember_token' => Str::random(10),
                'created_at'     => now(),
                'updated_at'     => now(),
            ],

        ]);

        for ($i = 4; $i <= 10; $i++) {
            DB::table('users')->insert([
                'name'           => 'test_user' . $i,
                'email'          => 'test' . $i . '@example.com',
                'password'       => Hash::make(config('12345678')),
                'profile_image'  => asset(config('user.profile_image_path.default')),
                'remember_token' => Str::random(10),
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }
    }
}
