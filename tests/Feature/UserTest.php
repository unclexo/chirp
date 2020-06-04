<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Jobs\FetchUser;
use App\Jobs\FetchFriends;
use App\Jobs\FetchFavorites;
use App\Jobs\FetchFollowers;
use App\Jobs\FetchMutedUsers;
use App\Jobs\FetchBlockedUsers;
use Illuminate\Support\Facades\Queue;

class UserTest extends TestCase
{
    /** @test */
    public function it_dispatches_jobs_when_an_user_is_created() : void
    {
        $user = factory(User::class)->create();

        Queue::assertPushed(fn (FetchBlockedUsers $j) => $j->user->is($user));
        Queue::assertPushed(fn (FetchFollowers $j) => $j->user->is($user));
        Queue::assertPushed(fn (FetchFriends $j) => $j->user->is($user));
        Queue::assertPushed(fn (FetchFavorites $j) => $j->user->is($user));
        Queue::assertPushed(fn (FetchMutedUsers $j) => $j->user->is($user));
        Queue::assertPushed(fn (FetchUser $j) => $j->user->is($user));
    }
}
