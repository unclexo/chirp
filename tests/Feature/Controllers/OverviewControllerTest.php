<?php

namespace Tests\Feature\Controllers;

use App\User;
use Tests\TestCase;

class OverviewControllerTest extends TestCase
{
    /** @test */
    public function it_displays_data_correctly() : void
    {
        $user          = factory(User::class)->states('with description', 'with URL')->create();
        $user->muted   = range(1, 10);
        $user->blocked = range(1, 10);

        $this
            ->actingAs($user)
            ->getJson(route('overview'))
            ->assertView()
            ->containsText($user->name)
            ->containsText($user->data->description)
            ->containsText('foo.bar')
            ->hasLink('https://foo.bar')
            ->containsText($user->data->location)
            ->containsText("{$user->presenter->statusesCount()} tweets")
            ->containsText("{$user->presenter->followersCount()} followers")
            ->containsText("{$user->presenter->friendsCount()} followings")
            ->containsText("{$user->presenter->favouritesCount()} likes")
            ->containsText("{$user->presenter->listedCount()} listed")
            ->containsText("{$user->muted->count()} muted users")
            ->containsText("{$user->blocked->count()} blocked users");
    }

    /** @test */
    public function it_displays_data_correctly_even_with_missing_info() : void
    {
        $this
            ->actingAs(factory(User::class)->create())
            ->getJson(route('overview'))
            ->assertOk();
    }
}
