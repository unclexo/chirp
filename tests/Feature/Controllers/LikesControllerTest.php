<?php

namespace Tests\Feature\Controllers;

use App\User;
use Tests\TestCase;

class LikesControllerTest extends TestCase
{
    /** @test */
    public function it_works() : void
    {
        $this
            ->actingAs(factory(User::class)->create())
            ->getJson(route('likes'))
            ->assertOk();
    }
}
