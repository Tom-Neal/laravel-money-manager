<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    /*
     * Registering cron jobs to run
     */

    protected $commands = [
        Commands\InvoiceItemRenewalRequiredCheck::class,
    ];

    protected function schedule(Schedule $schedule)
    {

        $schedule->call('App\Console\Commands\InvoiceItemRenewalRequiredCheck@handle')
            ->daily()
            ->at('09:00');

        // Run DB backup from package - dumps .sql file once per day
        $schedule->command('backup:clean')->daily()->at('01:00');
        $schedule->command('backup:run')->daily()->at('02:00');

    }

    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
