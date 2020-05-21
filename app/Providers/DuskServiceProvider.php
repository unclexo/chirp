<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DuskServiceProvider extends ServiceProvider
{
    public function register()
    {
        if (! $this->app->environment('production')) {
            $this->app->register(\Laravel\Dusk\DuskServiceProvider::class);
        }
    }
}
