<?php

namespace App\Console\Commands;

use App\User;
use App\Jobs\FetchUser;
use Illuminate\Console\Command;

class FetchUsersCommand extends Command
{
    protected $signature = 'fetch:users';

    protected $description = 'Fetch users';

    public function handle() : void
    {
        User::whereDisabled(false)->cursor()->each(function (User $user) {
            FetchUser::dispatch($user);
        });
    }
}
