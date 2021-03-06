<?php

namespace App\Console\Commands;

use App\User;
use App\Jobs\FetchUser;
use App\Jobs\FetchLikes;
use App\Jobs\FetchFollowers;
use App\Jobs\FetchFollowings;
use App\Jobs\FetchMutedUsers;
use App\Jobs\FetchBlockedUsers;
use Illuminate\Console\Command;

class FetchAllCommand extends Command
{
    protected $signature = 'fetch:all';

    protected $description = 'Fetch everything';

    public function handle() : void
    {
        // Let's use a Lazy Collection to stay memory efficient.
        // https://laravel.com/docs/collections#lazy-collections

        User::cursor()->each(function (User $user) {
            FetchBlockedUsers::dispatch($user);
            FetchFollowers::dispatch($user);
            FetchFollowings::dispatch($user);
            FetchLikes::dispatch($user);
            FetchMutedUsers::dispatch($user);
            FetchUser::dispatch($user);
        });
    }
}
