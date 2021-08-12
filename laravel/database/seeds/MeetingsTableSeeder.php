<?php

use Illuminate\Database\Seeder;
use App\Models\Meeting;

class MeetingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Meeting::class, 30)->create();
    }
}
