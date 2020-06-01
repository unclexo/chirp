<?php

namespace App\Console\Commands;

use App\User;
use App\Jobs\FetchFavorites;
use Illuminate\Console\Command;

class FetchFavoritesCommand extends Command
{
    protected $signature = 'fetch:favorites';

    protected $description = 'Fetch favorites';

    public function handle() : void
    {
        // Let's use a Lazy Collection to stay memory efficient.
        // https://laravel.com/docs/collections#lazy-collections
        User::cursor()->each(function (User $user) {
            FetchFavorites::dispatch($user);
        });
    }
}
