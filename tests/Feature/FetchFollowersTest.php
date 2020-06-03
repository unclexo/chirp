<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Facades\Twitter;
use App\Jobs\FetchFollowers;

class FetchFollowersTest extends TestCase
{
    /** @test */
    public function it_tracks_new_followers() : void
    {
        $usersLookup = json_decode(file_get_contents(database_path('twitter/json/users-lookup.json')));
        unset($usersLookup[3], $usersLookup[4]);

        $friendshipsLookup = json_decode(file_get_contents(database_path('twitter/json/friendships-lookup.json')));
        unset($friendshipsLookup[3], $friendshipsLookup[4]);

        Twitter::shouldReceive('setOauthToken')
            ->shouldReceive('get')
            ->with('followers/ids', ['cursor' => -1])
            ->andReturn(
                $data = json_decode(file_get_contents(database_path('twitter/json/followers-ids.json')))
            )
            ->shouldReceive('getLastHttpCode')
            ->andReturn(200)
            ->shouldReceive('get')
            ->with('users/lookup', ['user_id' => '1,2,3'])
            ->andReturn($usersLookup)
            ->shouldReceive('getLastHttpCode')
            ->andReturn(200)
            ->shouldReceive('get')
            ->with('friendships/lookup', ['user_id' => '1,2,3'])
            ->andReturn($friendshipsLookup)
            ->shouldReceive('getLastHttpCode')
            ->andReturn(200)
        ;

        $user = factory(User::class)->create(['followers' => [4, 5]]);

        FetchFollowers::dispatchNow($user);

        $this->assertCount(5, $user->followers);

        foreach ($user->followers as $follower) {
            $this->assertTrue(is_numeric($follower));
        }

        $diff = $user->diffs()->whereFor('followers')->latest()->first();

        $this->assertEquals('followers', $diff->for);
        $this->assertCount(3, $diff->additions);
        $this->assertCount(0, $diff->deletions);
    }

    /** @test */
    public function it_tracks_unfollowers() : void
    {
        $usersLookup = json_decode(file_get_contents(database_path('twitter/json/users-lookup.json')));
        unset($usersLookup[0], $usersLookup[1], $usersLookup[2]);

        $friendshipsLookup = json_decode(file_get_contents(database_path('twitter/json/friendships-lookup.json')));
        unset($friendshipsLookup[0], $friendshipsLookup[1], $friendshipsLookup[2]);

        Twitter::shouldReceive('setOauthToken')
            ->shouldReceive('get')
            ->with('followers/ids', ['cursor' => -1])
            ->andReturn(
                $data = json_decode(file_get_contents(database_path('twitter/json/followers-ids.json')))
            )
            ->shouldReceive('getLastHttpCode')
            ->andReturn(200)
            ->shouldReceive('get')
            ->with('users/lookup', ['user_id' => '4,5'])
            ->andReturn($usersLookup)
            ->shouldReceive('getLastHttpCode')
            ->andReturn(200)
            ->shouldReceive('get')
            ->with('friendships/lookup', ['user_id' => '4,5'])
            ->andReturn($friendshipsLookup)
            ->shouldReceive('getLastHttpCode')
            ->andReturn(200)
        ;

        $user = factory(User::class)->create(['followers' => [1, 2, 3]]);

        FetchFollowers::dispatchNow($user);

        $this->assertCount(5, $user->followers);

        foreach ($user->followers as $follower) {
            $this->assertTrue(is_numeric($follower));
        }

        $diff = $user->diffs()->whereFor('followers')->latest()->first();

        $this->assertEquals('followers', $diff->for);
        $this->assertCount(2, $diff->additions);
        $this->assertCount(0, $diff->deletions);
    }
}
