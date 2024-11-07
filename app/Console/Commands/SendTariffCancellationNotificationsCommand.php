<?php

namespace App\Console\Commands;

use App\Jobs\SendTariffCancellationNotificationJob;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendTariffCancellationNotificationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendTariffCancel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send tariff cancellation notifications 1 month in advance';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        logger('START SendTariffCancellationNotificationsCommand');
        $this->info('START SendTariffCancellationNotificationsCommand '.Carbon::now());
        $tariffs = Payment::select([
            'payments.id',
            'payments.user_id',
            'users.not_to_email',
            'users.email',
            'users.phone',
            'tariffs.title->ru as title',
            'payments.finished_at',
            DB::raw('DATE_FORMAT(payments.finished_at, "%d.%m.%Y %H:%i") as expired_at')
        ])
            ->where('payments.tariff_id', '!=', null)
            ->where('payments.is_confirmed', true)
            ->where('payments.status', 'Settled')
            ->whereDate('payments.finished_at', Carbon::now()->addMonth()->setTimezone('Europe/Moscow')->format('Y-m-d'))
            ->where('users.not_to_email', true) // true - разрешено отправлять на почту
            ->leftJoin('tariffs', 'tariffs.id', '=', 'payments.tariff_id')
            ->leftJoin('users', 'users.id', '=', 'payments.user_id')
            ->get();
        if(count($tariffs)) {
            foreach ($tariffs as $tariff) {
                dispatch((new SendTariffCancellationNotificationJob($tariff))->onQueue('user'));
            }
        }
        logger('END SendTariffCancellationNotificationsCommand');
        $this->info('END SendTariffCancellationNotificationsCommand '.Carbon::now());
        return 1;
    }
}
