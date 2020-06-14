<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Jobs\FetchLikes;
use Tests\Concerns\CreatesUser;

class ListLikesTest extends TestCase
{
    use CreatesUser;

    /** @test */
    public function guests_cannot_access_likes_page()
    {
        $this
            ->getJson(route('likes.index'))
            ->assertStatus(401)
        ;
    }

    /** @test */
    public function likes_are_listed() : void
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
