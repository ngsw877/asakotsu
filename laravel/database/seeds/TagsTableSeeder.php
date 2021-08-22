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
                'name' => config('tag.main')[0],
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id' => '2',
                'name' => config('tag.main')[1],
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id' => '3',
                'name' => config('tag.main')[2],
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id' => '4',
                'name' => config('tag.main')[3],
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id' => '5',
                'name' => config('tag.main')[4],
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
