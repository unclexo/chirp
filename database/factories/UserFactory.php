<?php

use App\User;
use Faker\Generator as Faker;

/* @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(User::class, function (Faker $faker) {
    $id = $faker->randomNumber();
    $data = json_decode(file_get_contents(database_path('json/account-verify_credentials.json')));
    $data->id = $id;
    $data->id_str = "$id";

    return [
        'id'           => $id,
        'name'         => $name = $faker->name,
        'nickname'     => $username = $faker->userName,
        'token'        => 'some-random-token',
        'token_secret' => 'some-random-secret-token',
        'data'         => $data,
        'followers'    => [],
        'friends'      => [],
        'muted'        => [],
        'blocked'      => [],
    ];
});
