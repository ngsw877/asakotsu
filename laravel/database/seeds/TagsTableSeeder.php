<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            [
                'id' => '1',
                'name' => '行動宣言',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id' => '2',
                'name' => '朝コツ',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id' => '3',
                'name' => '今朝の積み上げ',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id' => '4',
                'name' => '反省・気付き',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id' => '5',
                'name' => '質問',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
