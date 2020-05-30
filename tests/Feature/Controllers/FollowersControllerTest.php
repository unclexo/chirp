<?php

namespace Tests\Feature\Controllers;

use App\Diff;
use App\User;
use Tests\TestCase;

class FollowersControllerTest extends TestCase
{
    /** @test */
    public function it_works() : void
    {
        $user = factory(User::class)->create();

        $attributes = [
            'user_id' => $user->id,
            'for'     => 'followers',
        ];

        // Create diffs for 3 different dates.
        factory(Diff::class, 5)->create($attributes + ['created_at' => now()]);
        factory(Diff::class, 5)->create($attributes + ['created_at' => now()->subDay()]);
        factory(Diff::class, 5)->create($attributes + ['created_at' => now()->subWeek()]);

        $response = $this
            ->actingAs($user)
            ->getJson(route('followers'))
            ->assertOk();

        $diffs = $response->original->diffs;

        // Make sure I get diffs for 3 different dates.
        $this->assertCount(3, $diffs);

        $response->original->diffs->each(function (object $diff) use ($user) {
            // Make sure I got diffs for the correct user.
            $this->assertEquals($diff->user_id, $user->id);

            // I created 5 diffs for each day. Make sure they're all present.
            $this->assertCount(5, json_decode($diff->additions));
            $this->assertCount(5, json_decode($diff->deletions));
        });
    }
}
