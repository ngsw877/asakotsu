<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Article;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'body' => $faker->text(500),
        'user_id' => function() {
            return factory(User::class);
        }
    ];
});
