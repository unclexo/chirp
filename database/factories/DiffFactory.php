<?php

use App\Diff;
use Faker\Generator as Faker;

/* @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Diff::class, function (Faker $faker) {
    $user = json_decode(file_get_contents(database_path('json/users-lookup.json')))[0];
    $user->connections = [];

    return [
        'additions' => [$user],
        'deletions' => [$user],
    ];
});
