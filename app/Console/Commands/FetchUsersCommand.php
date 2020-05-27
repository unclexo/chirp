<?php

namespace App\Console\Commands;

use App\User;
use App\Jobs\FetchUser;
use Illuminate\Console\Command;

class FetchUserCommand extends Command
{
    protected $signature = 'fetch:users';

    protected $description = 'Fetch users';

    public function handle() : void
    {
        // Let's use a Lazy Collection to stay memory efficient.
        // https://laravel.com/docs/collections#lazy-collections
        User::cursor()->each(function (User $user) {
            FetchUser::dispatch($user);
        });
    }
}
