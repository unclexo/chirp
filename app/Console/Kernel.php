<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule) : void
    {
        // SQS doesn't support delayed jobs. We have to use the scheduler.
        $schedule->command('fetch:all')->spliceIntoPosition(1, '*/2');
    }

    protected function commands() : void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
