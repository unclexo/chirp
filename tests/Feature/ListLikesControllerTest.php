<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Jobs\FetchLikes;
use Tests\Concerns\CreatesUser;

class ListLikesControllerTest extends TestCase
{
    use CreatesUser;

    /** @test */
    public function it_works() : void
    {
        $user = $this->createUser();

        FetchLikes::dispatch($user);

        $this
            ->actingAs($user)
            ->getJson(route('likes.index'))
            ->assertOk()
            ->assertView()
            ->contains("{$user->presenter->favouritesCount()} likes")
        ;
    }
}
