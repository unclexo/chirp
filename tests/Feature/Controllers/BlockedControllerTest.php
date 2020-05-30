<?php

namespace Tests\Feature\Controllers;

use App\User;
use Tests\TestCase;

class BlockedControllerTest extends TestCase
{
    /** @test */
    public function it_works() : void
    {
        $this
            ->actingAs(factory(User::class)->create())
            ->getJson(route('blocked'))
            ->assertOk();
    }
}
