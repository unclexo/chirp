<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class ExampleTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function it_works() : void
    {
        $this->get('/')->assertOk();
    }
}
