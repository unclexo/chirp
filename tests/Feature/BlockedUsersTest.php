<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Jobs\FetchBlockedUsers;
use Tests\Concerns\CreatesUser;

class BlockedUsersTest extends TestCase
{
    use CreatesUser;

    /** @test */
    public function guests_cannot_access_blocked_users_page()
    {
        $this
            ->getJson(route('blocked'))
            ->assertStatus(401)
        ;
    }

    /** @test */
    public function blocked_users_are_listed() : void
    {
        FetchBlockedUsers::dispatch(
            $user = $this->createUser()
        );

        $this
            ->actingAs($user)
            ->getJson(route('blocked'))
            ->assertOk()
            ->assertView()
            ->contains(number_format($user->blocked_count) . ' blocked users')
        ;
    }
}
