<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Jobs\FetchBlockedUsers;
use Tests\Concerns\CreatesUser;

class BlockedControllerTest extends TestCase
{
    use CreatesUser;

    /** @test */
    public function it_works() : void
    {
        $user = $this->createUser();

        FetchBlockedUsers::dispatch($user);

        $this
            ->actingAs($user)
            ->getJson(route('blocked'))
            ->assertOk()
            ->assertView()
            ->contains("{$user->blocked->count()} blocked users")
        ;
    }
}
