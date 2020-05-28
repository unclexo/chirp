<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use App\Jobs\FetchFavoritedTweets;

class FetchFavoritedTweetsCommand extends Command
{
    protected $signature = 'fetch:favorites';

    protected $description = 'Fetch favorites';

    public function handle() : void
    {
        // Let's use a Lazy Collection to stay memory efficient.
        // https://laravel.com/docs/collections#lazy-collections
        User::cursor()->each(function (User $user) {
            FetchFavoritedTweets::dispatch($user);
        });
    }
}
