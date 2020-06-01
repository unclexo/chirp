<?php

use App\User;
use Faker\Generator as Faker;

/* @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(User::class, function (Faker $faker) {
    $twitterUserObject = require database_path('twitter/user.php');
    $twitterUserObject['id'] = $faker->randomNumber();
    $twitterUserObject['id_str'] = $twitterUserObject['id'];
    $twitterUserObject['name'] = $faker->name;
    $twitterUserObject['screen_name'] = $faker->userName;
    $twitterUserObject['location'] = $faker->city;
    $twitterUserObject['followers_count'] = rand(2, 1000);
    $twitterUserObject['friends_count'] = rand(2, 1000);
    $twitterUserObject['listed_count'] = rand(2, 1000);
    $twitterUserObject['favourites_count'] = rand(2, 1000);
    $twitterUserObject['statuses_count'] = rand(2, 1000);

    return [
        'id'           => $twitterUserObject['id'],
        'name'         => $twitterUserObject['name'],
        'nickname'     => $twitterUserObject['screen_name'],
        'token'        => 'some-random-token',
        'token_secret' => 'some-random-secret-token',
        'data'         => $twitterUserObject,
        'followers'    => [],
        'friends'      => [],
        'muted'        => [],
        'blocked'      => [],
    ];
});

foreach (['following', 'following_requested', 'followed_by', 'none', 'blocking', 'muting'] as $connection) {
    $factory->afterMakingState(User::class, $connection, function (User $user) use ($connection) {
        $data = $user->data;
        $data['connections'] = $user->data['connections'] ?? [];
        $data['connections'][] = $connection;
        $user->data = $data;
    });
}

$factory->afterMakingState(User::class, 'with description', function (User $user, Faker $faker) {
    $data = $user->data;
    $data->description = $faker->paragraph;
    $data->entities->description = (object) ['urls' => []];
    $user->data = $data;
});

$factory->afterMakingState(User::class, 'with settings', function (User $user, Faker $faker) {
    $data = $user->data;
    $data->settings = (object) [
        // The timezone is the only thing I use from the user's settings.
        'time_zone'=> [
            'tzinfo_name' => $faker->timezone,
        ],
    ];
    $user->data = $data;
});

$factory->afterMakingState(User::class, 'with URL', function (User $user, Faker $faker) {
    $data = $user->data;
    $data->url = 'https://foo.bar';
    $data->entities->url = (object) [
        'urls' => [[
            'url'          => 'https://t.co/bar',
            'display_url'  => 'foo.bar',
            'expanded_url' => 'https://foo.bar',
        ]],
    ];
    $user->data = $data;
});
