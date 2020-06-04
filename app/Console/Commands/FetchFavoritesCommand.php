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
        User::cursor()->each(function (User $user) {
            FetchFavorites::dispatch($user);
        });
    }
}
