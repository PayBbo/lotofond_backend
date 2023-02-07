<?php

namespace App\Console;

use App\Jobs\EGRNStatementJob;
use App\Jobs\FavouriteJob;
use App\Jobs\FixDescription;
use App\Jobs\MonitoringJob;
use App\Jobs\MonitoringNotificationJob;
use App\Jobs\NewUsersNotificationsJob;
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
        $schedule->job((new ParseTrades)->onQueue('parse'))->hourly()->timezone('Europe/Moscow');
        $schedule->job((new MonitoringJob)->onQueue('parse'))->hourly()->timezone('Europe/Moscow');
        $schedule->job((new MonitoringNotificationJob('hourly'))->onQueue('parse'))->hourly()->timezone('Europe/Moscow');
        $schedule->job((new MonitoringNotificationJob('daily'))->onQueue('parse'))->daily()->timezone('Europe/Moscow');
        $schedule->job((new MonitoringNotificationJob('weekly'))->onQueue('parse'))->weekly()->timezone('Europe/Moscow');
        $schedule->job((new FavouriteJob)->onQueue('parse'))->hourly()->timezone('Europe/Moscow');
        $schedule->job((new ParseSRORegister)->onQueue('parse'))->daily()->timezone('Europe/Moscow');
        $schedule->job((new ParseArbitrManager)->onQueue('parse'))->daily()->timezone('Europe/Moscow');
        $schedule->job((new ParseCompanyTradeOrganizer)->onQueue('parse'))->daily()->timezone('Europe/Moscow');
        $schedule->job((new ParseDebtor)->onQueue('parse'))->daily()->timezone('Europe/Moscow');
        $schedule->job((new ParseDebtorMessages)->onQueue('parse'))->hourly()->timezone('Europe/Moscow');
        $schedule->job((new SendLotsToChannel)->onQueue('parse'))->hourly()->timezone('Europe/Moscow')->between('8:00', '20:00');
        $schedule->job((new EGRNStatementJob)->onQueue('user'))->dailyAt('08:30')->timezone('Europe/Moscow');
        $schedule->job((new FixDescription)->onQueue('parse'))->dailyAt('03:30')->timezone('Europe/Moscow');
        $schedule->job((new NewUsersNotificationsJob)->onQueue('user'))->dailyAt('20:00')->timezone('Europe/Moscow');
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
