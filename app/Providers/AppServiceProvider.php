<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Abraham\TwitterOAuth\TwitterOAuth;
use App\Twitter\TwitterOAuthWithCache;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot() : void
    {
        if (! is_dir(config('view.compiled'))) {
            mkdir(config('view.compiled'), 0755, true);
        }

        Paginator::defaultSimpleView('pagination::simple-default');
        Paginator::defaultView('pagination::default');
    }

    public function register() : void
    {
        $this->app->bind('twitter', function (Application $app) {
            $arguments = [
                $app['config']->get('services.twitter.client_id'),
                $app['config']->get('services.twitter.client_secret'),
            ];

            return $app->environment('testing')
                ? new TwitterOAuthWithCache(...$arguments)
                : new TwitterOAuth(...$arguments);
        });
    }
}
