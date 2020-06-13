<?php

namespace App\Console\Commands;

use App\User;
use App\Jobs\FetchLikes;
use Illuminate\Console\Command;

class FetchLikesCommand extends Command
{
    protected $signature = 'fetch:likes';

    protected $description = 'Fetch likes';

    public function handle() : void
    {
        User::cursor()->each(function (User $user) {
            FetchLikes::dispatch($user);
        });
    }
}
