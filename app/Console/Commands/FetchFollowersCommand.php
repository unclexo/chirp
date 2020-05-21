<?php

namespace App\Console\Commands;

use App\User;
use App\Jobs\FetchFollowers;
use Illuminate\Console\Command;

class FetchFollowersCommand extends Command
{
    protected $signature = 'fetch:followers';

    protected $description = 'Fetch followers';

    public function handle() : void
    {
        // Let's use a Lazy Collection to stay memory efficient.
        // https://laravel.com/docs/collections#lazy-collections
        User::cursor()->each(function (User $user) {
            FetchFollowers::dispatch($user);
        });
    }
}
