<?php

namespace App\Listeners;

use App\Jobs\FetchLikes;
use App\Jobs\FetchFollowers;
use App\Jobs\FetchFollowings;
use App\Jobs\FetchMutedUsers;
use App\Jobs\FetchBlockedUsers;
use Illuminate\Auth\Events\Registered;

class FetchNewUserData
{
    public function handle(Registered $event)
    {
        FetchBlockedUsers::dispatch($event->user);
        FetchFollowers::dispatch($event->user);
        FetchFollowings::dispatch($event->user);
        FetchLikes::dispatch($event->user);
        FetchMutedUsers::dispatch($event->user);
    }
}
