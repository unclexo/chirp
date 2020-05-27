<?php

namespace Tests\Feature\Jobs;

use App\User;
use Tests\TestCase;
use App\Jobs\FetchUser;
use App\Facades\Twitter;
use Illuminate\Foundation\Testing\WithFaker;

class FetchUserTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function it_fetches_users() : void
    {
        Twitter::shouldReceive('setOauthToken')
            ->shouldReceive('get')
            ->with('account/verify_credentials')
            ->andReturn(
                json_decode(file_get_contents(__DIR__ . '/../../json/account-verify_credentials.json'))
            )
            ->shouldReceive('getLastHttpCode')
            ->andReturn(200)
            ->shouldReceive('get')
            ->with('account/settings')
            ->andReturn(
                json_decode(file_get_contents(__DIR__ . '/../../json/account-settings.json'))
            )
            ->shouldReceive('getLastHttpCode')
            ->andReturn(200);

        $user = factory(User::class)->create();

        FetchUser::dispatchNow($user);

        $this->assertEquals(1, $user->id);
        $this->assertEquals('Homer Simpson', $user->name);
        $this->assertEquals('homersimpson', $user->nickname);
        $this->assertNotNull($user->data->settings);
    }
}
