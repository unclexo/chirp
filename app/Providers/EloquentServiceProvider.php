<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class EloquentServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Custom polymorphic types, useful if models' namespace changes:
        // https://laravel.com/docs/eloquent-relationships#polymorphic-relations
        Relation::morphMap([
            User::class,
        ]);
    }
}
