<?php

use App\Favorite;
use Faker\Generator as Faker;

/* @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Favorite::class, function (Faker $faker) {
    $id       = $faker->randomNumber();
    $favorite = json_decode(
        file_get_contents(database_path('json/favorites-list.json'))
    )[0];
    $favorite->id     = $id;
    $favorite->id_str = "$id";

    return [
        'id'   => $id,
        'data' => $favorite,
    ];
});
