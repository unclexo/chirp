<?php

namespace Tests\Concerns;

use App\User;
use App\Jobs\FetchUser;

trait CreatesUser
{
    /** @test */
    public function createUser() : User
    {
        $user = factory(User::class)->create();

        FetchUser::dispatch($user);

        return $user;
    }
}
