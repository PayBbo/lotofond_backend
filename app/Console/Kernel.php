<?php

namespace App\Console;

use App\Jobs\FavouriteJob;
use App\Jobs\MonitoringJob;
use App\Jobs\MonitoringNotificationJob;
use App\Jobs\ParseArbitrManager;
use App\Jobs\ParseCompanyTradeOrganizer;
use App\Jobs\ParseDebtor;
use App\Jobs\ParseDebtorMessages;
use App\Jobs\ParseSRORegister;
use App\Jobs\ParseTrades;
use App\Jobs\SendLotsToChannel;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Cache;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->job((new ParseTrades)->onQueue('parse'))->hourly();
        $schedule->job((new MonitoringJob)->onQueue('parse'))->hourly();
        $schedule->job((new MonitoringNotificationJob('hourly'))->onQueue('parse'))->hourly();
        $schedule->job((new MonitoringNotificationJob('daily'))->onQueue('parse'))->daily();
        $schedule->job((new MonitoringNotificationJob('weekly'))->onQueue('parse'))->weekly();
        $schedule->job((new FavouriteJob)->onQueue('parse'))->hourly();
        $schedule->job((new ParseSRORegister)->onQueue('parse'))->daily();
        $schedule->job((new ParseArbitrManager)->onQueue('parse'))->daily();
        $schedule->job((new ParseCompanyTradeOrganizer)->onQueue('parse'))->daily();
        $schedule->job((new ParseDebtor)->onQueue('parse'))->daily();
        $schedule->job((new ParseDebtorMessages)->onQueue('parse'))->hourly();
        if (Cache::get('countRealtyLotsChannel') < 10 || Cache::get('countTransportLotsChannel')) {
            $schedule->job((new SendLotsToChannel)->onQueue('parse'))->hourly();
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
