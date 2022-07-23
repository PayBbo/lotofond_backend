<?php

namespace App\Console;

use App\Jobs\FavouriteJob;
use App\Jobs\MonitoringJob;
use App\Jobs\ParseArbitrManager;
use App\Jobs\ParseCompanyTradeOrganizer;
use App\Jobs\ParseDebtor;
use App\Jobs\ParseDebtorMessages;
use App\Jobs\ParseSRORegister;
use App\Jobs\ParseTrades;
use App\Models\Favourite;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new ParseTrades)->hourly();
        $schedule->job(new MonitoringJob)->hourly();
        $schedule->job(new FavouriteJob)->hourly();
        $schedule->job(new ParseArbitrManager)->hourly();
        $schedule->job(new ParseCompanyTradeOrganizer)->hourly();
        $schedule->job(new ParseSRORegister)->hourly();
        $schedule->job(new ParseDebtor)->hourly();
        $schedule->job(new ParseDebtorMessages)->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
