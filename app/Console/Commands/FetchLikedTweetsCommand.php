<?php

namespace App\Console\Commands;

use App\User;
use App\Jobs\FetchLikedTweets;
use Illuminate\Console\Command;

class FetchLikedTweetsCommand extends Command
{
    protected $signature = 'fetch:likes';

    protected $description = 'Fetch likes';

    public function handle() : void
    {
        // Let's use a Lazy Collection to stay memory efficient.
        // https://laravel.com/docs/collections#lazy-collections
        User::cursor()->each(function (User $user) {
            FetchLikedTweets::dispatch($user);
        });
    }
}
