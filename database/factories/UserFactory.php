<?php

use App\User;
use Faker\Generator as Faker;

/* @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(User::class, function (Faker $faker) {
    $twitterUserObject = json_decode(file_get_contents(database_path('twitter/json/account-verify_credentials.json')));
    $twitterUserObject->id = $faker->randomNumber();
    $twitterUserObject->id_str = $twitterUserObject->id;
    $twitterUserObject->name = $faker->name;
    $twitterUserObject->screen_name = $faker->userName;

    return [
        'id'           => $twitterUserObject->id,
        'name'         => $twitterUserObject->name,
        'nickname'     => $twitterUserObject->screen_name,
        'token'        => 'some-random-token',
        'token_secret' => 'some-random-secret-token',
        'data'         => $twitterUserObject,
        'followers'    => [],
        'friends'      => [],
        'muted'        => [],
        'blocked'      => [],
    ];
});
