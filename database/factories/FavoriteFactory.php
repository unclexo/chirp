<?php

use Faker\Generator as Faker;

/* @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Favorite::class, function (Faker $faker) {
    return [
        'id'      => $faker->randomNumber(),
        'user_id' => $faker->randomDigitNotNull,
        'data'    => [],
    ];
});