<?php

namespace App\Console;

use App\Jobs\FetchUser;
use App\Jobs\FetchFriends;
use App\Jobs\FetchFollowers;
use App\Jobs\FetchMutedUsers;
use App\Jobs\FetchBlockedUsers;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule) : void
    {
        // SQS doesn't support delayed jobs. We have to use the scheduler.

        $schedule->call(function () {
            FetchBlockedUsers::dispatch($user);
            FetchFollowers::dispatch($user);
            FetchFriends::dispatch($user);
            FetchMutedUsers::dispatch($user);
            FetchUser::dispatch($user);
        })->everyFiveMinutes();

        $schedule->call(function () {
            FetchFavoritedTweets::dispatch($user);
        })->everyFifteenMinutes();
    }

    protected function commands() : void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
