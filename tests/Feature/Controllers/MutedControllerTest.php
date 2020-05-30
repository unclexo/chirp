<?php

namespace Tests\Feature\Controllers;

use App\User;
use Tests\TestCase;

class MutedControllerTest extends TestCase
{
    /** @test */
    public function it_works() : void
    {
        $this
            ->actingAs(factory(User::class)->create())
            ->getJson(route('muted'))
            ->assertOk();
    }
}
