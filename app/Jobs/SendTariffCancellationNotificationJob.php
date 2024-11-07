<?php

namespace App\Jobs;

use App\Http\Services\SendCodeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTariffCancellationNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tariff;

    /**
     * Create a new job instance.
     *
     * @param $tariff
     */
    public function __construct($tariff)
    {
        $this->tariff = $tariff;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            logger('SendTariffCancellationNotificationJob');
            $sendEmail = new SendCodeService();
            $sendEmail->sendTariffCancellationNotification($this->tariff);
        }
        catch (\Exception $e) {
            logger('SendTariffCancellationNotificationJob error = '.$e->getMessage());
        }

    }
}
