<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Concerns\CreatesUser;

class OverviewControllerTest extends TestCase
{
    use CreatesUser;

    /** @test */
    public function it_works() : void
    {
        $this
            ->actingAs($user = $this->createUser())
            ->getJson(route('overview'))
            ->assertOk()
            ->assertView()
            ->contains($user->name)
            ->contains($user->data->description)
            ->contains($user->data->location)
            ->contains($user->presenter->date())
        ;
    }
}
