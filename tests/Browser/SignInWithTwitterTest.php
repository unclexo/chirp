<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Support\Facades\Artisan;

// This test's been written to ensure the "Sign in with Twitter" link works as intended.
// We check for registration and jobs execution by hitting the real stuff, not mocks.
class SignInWithTwitterTest extends DuskTestCase
{
    /** @test */
    public function users_can_sign_in_with_twitter() : void
    {
        Artisan::call('migrate:fresh');

        $this->browse(function (Browser $browser) {
            $browser
                ->visitRoute('home')
                ->assertSee('Meet ' . config('app.name'))
                ->assertSee('A free Twitter activity tracker')
                ->clickLink('Sign in with Twitter')
                // Now, we're on twitter.com.
                ->waitForLocation('/oauth/authenticate')
                ->type('session[username_or_email]', config('services.twitter.test_user_name'))
                ->type('session[password]', config('services.twitter.test_user_password'))
                ->click('#allow')
                // Back to the app…
                ->waitForRoute('overview')
            ;
        });

        $this->assertDatabaseHas('users', ['name' => 'Benjamin Crozat']);
    }
}
