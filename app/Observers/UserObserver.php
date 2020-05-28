<?php

namespace App\Observers;

use App\User;
use App\Jobs\FetchUser;
use App\Jobs\FetchFriends;
use App\Jobs\FetchFollowers;
use App\Jobs\FetchMutedUsers;
use App\Jobs\FetchLikedTweets;
use App\Jobs\FetchBlockedUsers;

// I'm using an observer here instead of closures inside the User model,
// because users need to be serialized when sent to SQS inside jobs.
class UserObserver
{
    public function created(User $user) : void
    {
        FetchBlockedUsers::dispatch($user);
        FetchFollowers::dispatch($user);
        FetchFriends::dispatch($user);
        FetchLikedTweets::dispatch($user);
        FetchMutedUsers::dispatch($user);
        FetchUser::dispatch($user);
    }
}
