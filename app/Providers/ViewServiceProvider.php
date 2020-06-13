<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot() : void
    {
        if (! is_dir(Config::get('view.compiled'))) {
            mkdir(Config::get('view.compiled'), 0755, true);
        }

        Paginator::defaultSimpleView('pagination::simple-default');
        Paginator::defaultView('pagination::default');

        View::composer('*', fn ($v) => $v->withUser($this->app['auth']->user()));
    }
}
