<?php

namespace App\Console\Commands;

use App\User;
use App\Jobs\FetchFollowers;
use Illuminate\Console\Command;

class FetchFollowersCommand extends Command
{
    protected $signature = 'fetch:followers';

    protected $description = 'Fetch followers';

    public function handle() : void
    {
        User::cursor()->each(function (User $user) {
            FetchFollowers::dispatch($user);
        });
    }
}
