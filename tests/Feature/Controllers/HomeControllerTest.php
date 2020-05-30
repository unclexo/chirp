<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    /** @test */
    public function it_works() : void
    {
        $this
            ->getJson(route('home'))
            ->assertOk();
    }
}
