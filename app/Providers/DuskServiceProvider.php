<?php

namespace App\Providers;

use Laravel\Dusk\Browser;
use Illuminate\Support\ServiceProvider;
use PHPUnit\Framework\Assert as PHPUnit;

class DuskServiceProvider extends ServiceProvider
{
    public function boot() : void
    {
        Browser::macro('seeLinkWithText', function (string $url, string $text) {
            return $this->driver->executeScript(<<<JS
var found = false

document.querySelectorAll("a").forEach(link => {
    if (
        ! found &&
        link.textContent.trim().replace(/\\n|\\r/g, '').replace(/\\s{2,}/g, ' ') === "{$text}" &&
        "{$url}" === link.href
    ) {
        found = true
    }
})

return found
JS);
        });

        Browser::macro('assertSeeLinkWithText', function (string $url, string $text) {
            PHPUnit::assertTrue(
                $this->seeLinkWithText($url, $text)
            );

            return $this;
        });
    }

    public function register() : void
    {
        if (! $this->app->environment('production')) {
            $this->app->register(\Laravel\Dusk\DuskServiceProvider::class);
        }
    }
}
