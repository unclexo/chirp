<?php

namespace App\Console\Commands;

use App\User;
use App\Jobs\FetchBlockedUsers;
use Illuminate\Console\Command;

class FetchBlockedCommand extends Command
{
    protected $signature = 'fetch:blocked';

    protected $description = 'Fetch blocked users';

    public function handle() : void
    {
        User::whereDisabled(false)->cursor()->each(function (User $user) {
            FetchBlockedUsers::dispatch($user);
        });
    }
}
