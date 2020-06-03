<?php

namespace Tests\Feature\Jobs;

use App\User;
use Tests\TestCase;
use App\Facades\Twitter;
use App\Jobs\FetchBlockedUsers;

class FetchBlockedUsersTest extends TestCase
{
    /** @test */
    public function it_fetches_blocked_users() : void
    {
        Twitter::shouldReceive('setOauthToken')
            ->shouldReceive('get')
            ->with('blocks/ids', ['cursor' => -1])
            ->andReturn(
                $data = json_decode(file_get_contents(database_path('twitter/json/blocked-ids.json')))
            )
            ->shouldReceive('getLastHttpCode')
            ->andReturn(200)
            ->shouldReceive('get')
            ->with('users/lookup', ['user_id' => implode(',', $data->ids)])
            ->andReturn(
                json_decode(file_get_contents(database_path('twitter/json/users-lookup.json')))
            )
            ->shouldReceive('getLastHttpCode')
            ->andReturn(200)
            ->shouldReceive('get')
            ->with('friendships/lookup', ['user_id' => implode(',', $data->ids)])
            ->andReturn(
                json_decode(file_get_contents(database_path('twitter/json/friendships-lookup.json')))
            )
            ->shouldReceive('getLastHttpCode')
            ->andReturn(200);

        $user = factory(User::class)->create();

        $this->assertCount(0, $user->blocked);

        FetchBlockedUsers::dispatchNow($user);

        $this->assertCount(5, $user->blocked);

        foreach ($user->blocked as $blockedUser) {
            $this->assertArrayHasKey('connections', $blockedUser);
        }
    }
}
