<?php

namespace Tests\Feature\Controllers;

use App\Diff;
use App\User;
use App\Favorite;
use Tests\TestCase;

class DeleteUserControllerTest extends TestCase
{
    /** @test */
    public function it_deletes_user_and_all_associated_data() : void
    {
        $user = factory(User::class)->create();
        $user->diffs()->saveMany(factory(Diff::class, 5)->make(['for' => 'followers']));
        $user->favorites()->saveMany(factory(Favorite::class, 5)->make());

        $this
            ->actingAs($user)
            ->deleteJson(route('user.delete'))
            ->assertRedirect();

        $this->assertTrue(User::all()->isEmpty());
        $this->assertTrue(Diff::all()->isEmpty());
        $this->assertTrue(Favorite::all()->isEmpty());
    }
}
