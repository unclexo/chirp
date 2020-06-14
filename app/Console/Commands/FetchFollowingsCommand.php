<?php

namespace App\Console\Commands;

use App\User;
use App\Jobs\FetchFollowings;
use Illuminate\Console\Command;

class FetchFollowingsCommand extends Command
{
    protected $signature = 'fetch:followings';

    protected $description = 'Fetch followings';

    public function handle() : void
    {
        User::cursor()->each(function (User $user) {
            FetchFollowings::dispatch($user);
        });
    }
}
