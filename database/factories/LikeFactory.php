<?php

use App\Like;
use Faker\Generator as Faker;

/* @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Like::class, function (Faker $faker) {
    return [
        'id'      => $faker->randomDigitNotNull,
        'user_id' => $faker->randomDigitNotNull,
        'data'    => [],
    ];
});
