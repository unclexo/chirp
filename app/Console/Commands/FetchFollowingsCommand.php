<?php

namespace App\Console\Commands;

use App\User;
use App\Jobs\FetchFriends;
use Illuminate\Console\Command;

class FetchFollowingsCommand extends Command
{
    protected $signature = 'fetch:followings';

    protected $description = 'Fetch followings';

    public function handle() : void
    {
        // Let's use a Lazy Collection to stay memory efficient.
        // https://laravel.com/docs/collections#lazy-collections
        User::cursor()->each(function (User $user) {
            FetchFriends::dispatch($user);
        });
    }
}
