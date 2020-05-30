<?php

namespace Tests\Unit;

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
    public function it_deletes_an_user_when_tokens_have_been_invalidated() : void
    {
        Twitter::shouldReceive('setOauthToken')
            ->shouldReceive('get')
            ->with('foo/bar')
            ->andReturn(
                $data = json_decode(file_get_contents(base_path('database/json/error-403.json')))
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
