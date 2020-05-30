<?php

namespace Tests\Feature\Controllers;

use App\User;
use Tests\TestCase;

class OverviewControllerTest extends TestCase
{
    /** @test */
    public function it_works() : void
    {
        $this
            ->actingAs(factory(User::class)->create())
            ->getJson(route('overview'))
            ->assertOk();
    }
}
