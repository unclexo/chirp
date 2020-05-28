<?php

namespace Tests\Feature\Jobs;

use App\User;
use Exception;
use Tests\TestCase;
use App\Facades\Twitter;
use App\Jobs\Traits\CallsTwitter;

class CallsTwitterTest extends TestCase
{
    use CallsTwitter;

    protected User $user;

    public function setUp() : void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function it_throws_an_exception_when_twitter_returns_an_error() : void
    {
        Twitter::shouldReceive('setOauthToken')
            ->shouldReceive('get')
            ->with('foo/bar')
            ->andReturn(
                $data = json_decode(file_get_contents(__DIR__ . '/../json/error-404.json'))
            )
            ->shouldReceive('getLastHttpCode')
            ->andReturn(404);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Sorry, this page does not exist.');

        $this->checkForTwitterErrors(
            Twitter::get('foo/bar')
        );
    }

    /** @test */
    public function it_deletes_an_user_when_tokens_have_been_invalidated() : void
    {
        Twitter::shouldReceive('setOauthToken')
            ->shouldReceive('get')
            ->with('foo/bar')
            ->andReturn(
                $data = json_decode(file_get_contents(__DIR__ . '/../json/error-403.json'))
            )
            ->shouldReceive('getLastHttpCode')
            ->andReturn(403);

        try {
            $this->checkForTwitterErrors(
                Twitter::get('foo/bar')
            );
        } catch (Exception $e) {
        }

        $this->assertDatabaseMissing('users', ['id' => $this->user->id]);
    }
}