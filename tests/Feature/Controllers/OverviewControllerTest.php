<?php

namespace Tests\Feature\Controllers;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class OverviewControllerTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function it_works() : void
    {
        $this
            ->actingAs(factory(User::class)->create())
            ->getJson(route('overview'))
            ->assertOk();
    }
}
