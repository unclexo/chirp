<?php

namespace Tests\Feature\Jobs;

use App\User;
use Tests\TestCase;
use App\Facades\Twitter;
use App\Jobs\FetchFriends;
use Illuminate\Foundation\Testing\WithFaker;

class FetchFriendsTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function it_tracks_new_followings() : void
    {
        $usersLookup = json_decode(file_get_contents(base_path('tests/json/users-lookup.json')));
        unset($usersLookup[3], $usersLookup[4]);

        $friendshipsLookup = json_decode(file_get_contents(base_path('tests/json/friendships-lookup.json')));
        unset($friendshipsLookup[3], $friendshipsLookup[4]);

        Twitter::shouldReceive('setOauthToken')
            ->shouldReceive('get')
            ->with('friends/ids', ['cursor' => -1])
            ->andReturn(
                $data = json_decode(file_get_contents(base_path('tests/json/friends-ids.json')))
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

        $user = factory(User::class)->create(['friends' => [4, 5]]);

        FetchFriends::dispatchNow($user);

        $this->assertCount(5, $user->friends);

        foreach ($user->friends as $following) {
            $this->assertTrue(is_numeric($following));
        }

        $diff = $user->diffs()->whereFor('friends')->latest()->first();

        $this->assertEquals('friends', $diff->for);
        $this->assertCount(3, $diff->additions);
        $this->assertCount(0, $diff->deletions);
    }

    /** @test */
    public function it_tracks_unfollowings() : void
    {
        $usersLookup = json_decode(file_get_contents(base_path('tests/json/users-lookup.json')));
        unset($usersLookup[0], $usersLookup[1], $usersLookup[2]);

        $friendshipsLookup = json_decode(file_get_contents(base_path('tests/json/friendships-lookup.json')));
        unset($friendshipsLookup[0], $friendshipsLookup[1], $friendshipsLookup[2]);

        Twitter::shouldReceive('setOauthToken')
            ->shouldReceive('get')
            ->with('friends/ids', ['cursor' => -1])
            ->andReturn(
                $data = json_decode(file_get_contents(base_path('tests/json/friends-ids.json')))
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

        $user = factory(User::class)->create(['friends' => [1, 2, 3]]);

        FetchFriends::dispatchNow($user);

        $this->assertCount(5, $user->friends);

        foreach ($user->friends as $following) {
            $this->assertTrue(is_numeric($following));
        }

        $diff = $user->diffs()->whereFor('friends')->latest()->first();

        $this->assertEquals('friends', $diff->for);
        $this->assertCount(2, $diff->additions);
        $this->assertCount(0, $diff->deletions);
    }
}
