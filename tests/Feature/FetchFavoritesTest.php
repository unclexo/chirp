<?php

namespace Tests\Feature\Jobs;

use App\User;
use Tests\TestCase;
use App\Facades\Twitter;
use Illuminate\Support\Arr;
use App\Jobs\FetchFavorites;

class FetchFavoritesTest extends TestCase
{
    /** @test */
    public function it_fetches_blocked_users() : void
    {
        $data = json_decode(file_get_contents(database_path('twitter/json/favorites-list.json')));

        Twitter::shouldReceive('setOauthToken')
            // First run of the loop.
            ->shouldReceive('get')
            ->with('favorites/list', [
                'count'      => 200,
                'tweet_mode' => 'extended',
            ])
            ->andReturn($data)
            ->shouldReceive('getLastHttpCode')
            ->andReturn(200)
            // Second run.
            ->shouldReceive('setOauthToken')
            ->shouldReceive('get')
            ->with('favorites/list', [
                'count'      => 200,
                'tweet_mode' => 'extended',
                'max_id'     => 1255411460391526400,
            ])
            ->andReturn([Arr::last($data)])
            ->shouldReceive('getLastHttpCode')
            ->andReturn(200);

        $user = factory(User::class)->create();

        FetchFavorites::dispatchNow($user);
    }
}
