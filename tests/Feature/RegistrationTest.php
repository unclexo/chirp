<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Jobs\FetchUser;
use App\Jobs\FetchLikes;
use App\Jobs\FetchFollowers;
use App\Jobs\FetchFollowings;
use App\Jobs\FetchMutedUsers;
use App\Jobs\FetchBlockedUsers;
use Tests\Concerns\CreatesUser;
use Illuminate\Support\Facades\Bus;
use Illuminate\Auth\Events\Registered;

class RegistrationTest extends TestCase
{
    use CreatesUser;

    /** @test */
    public function jobs_are_dispatched_after_registration()
    {
        Bus::fake();

        event(new Registered($this->createUser()));

        Bus::assertDispatched(FetchBlockedUsers::class);
        Bus::assertDispatched(FetchFollowers::class);
        Bus::assertDispatched(FetchFollowings::class);
        Bus::assertDispatched(FetchLikes::class);
        Bus::assertDispatched(FetchMutedUsers::class);
        Bus::assertDispatched(FetchUser::class);
    }
}
