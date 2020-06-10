<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain'   => env('MAILGUN_DOMAIN'),
        'secret'   => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'twitter' => [
        'client_id'              => env('TWITTER_API_KEY'),
        'client_secret'          => env('TWITTER_API_SECRET_KEY'),
        'test_user_name'         => env('TWITTER_TEST_USER_NAME'),
        'test_user_password'     => env('TWITTER_TEST_USER_PASSWORD'),
        'test_user_token'        => env('TWITTER_TEST_USER_TOKEN'),
        'test_user_token_secret' => env('TWITTER_TEST_USER_TOKEN_SECRET'),
        'redirect'               => env('APP_URL') . '/login/callback',
    ],
];
