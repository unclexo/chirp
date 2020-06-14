<?php

namespace App\Providers;

use App\Twitter\TwitterOAuthWithCache;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register() : void
    {
        $this->app->bind('twitter', function (Application $app) {
            $arguments = [
                $app['config']->get('services.twitter.client_id'),
                $app['config']->get('services.twitter.client_secret'),
            ];

            return new TwitterOAuthWithCache(...$arguments);
        });
    }
}
