<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Abraham\TwitterOAuth\TwitterOAuth;
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
        $this->app->bind('twitter', fn ($app) => new TwitterOAuth(
            $app['config']->get('services.twitter.client_id'),
            $app['config']->get('services.twitter.client_secret')
        ));
    }
}
