<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class HomeControllerTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function it_works() : void
    {
        $this
            ->getJson(route('home'))
            ->assertOk();
    }
}
