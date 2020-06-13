<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Concerns\CreatesUser;

class OverviewControllerTest extends TestCase
{
    use CreatesUser;

    /** @test */
    public function it_does_something() : void
    {
        $this
            ->actingAs($this->createUser())
            ->getJson(route('overview'))
            ->assertOk();
    }
}
