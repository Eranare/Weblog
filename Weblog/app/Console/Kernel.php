<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        // Schedule the command to run daily
        $schedule->command('subscriptions:deactivate-expired')->daily();
    }

    protected function commands()
    {
        // Automatically load commands from the Console/Commands directory
        $this->load(__DIR__.'/Commands');
    }
}