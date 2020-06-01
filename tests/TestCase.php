<?php

namespace Tests;

use PHPUnit\Framework\Assert;
use Illuminate\Support\Facades\Queue;
use NunoMaduro\LaravelMojito\ViewAssertion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();

        Queue::fake();

        ViewAssertion::macro('containsText', function (string $text) {
            $this->assert(function () use ($text) {
                Assert::assertStringContainsString((string) $text, $this->crawler->text());
            }, "Failed asserting that the text `$text` exists within %s.");

            return $this;
        });
    }
}
