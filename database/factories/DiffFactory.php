<?php

use App\Diff;
use Faker\Generator as Faker;

/* @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Diff::class, function (Faker $faker) {
    return [
        'additions' => [],
        'deletions' => [],
    ];
});
