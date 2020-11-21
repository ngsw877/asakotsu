<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Meeting;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Meeting::class, function (Faker $faker) {
    return [
        'meeting_id' => $faker->randomNumber(9),
        'topic' => $faker->text(20),
        'agenda' => $faker->text(20),
        'start_time' => $faker->dateTime,
        'start_url' => $faker->url,
        'join_url' => $faker->url,
        'user_id' => function() {
            return factory(User::class);
        }
    ];
});
