<?php

namespace App\Jobs;

use App\Http\Services\SendCodeService;
use App\Models\Contact;
use App\Models\Tariff;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NewUsersNotificationsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $startTime = Carbon::now()->setTimezone('Europe/Moscow')->subDay();
        $endTime = Carbon::now()->setTimezone('Europe/Moscow');
        $users = User::whereBetween('email_verified_at', [$startTime, $endTime])->orderBy('email_verified_at', 'desc')->get();
        $tariff = Tariff::where('code', 'newUsers')->first();
        $toEmail = Contact::where('tariff_id', $tariff->id)->pluck('contact')->toArray();
        if($users->count() > 0 && count($toEmail) > 0) {
            $sendCodeService = new SendCodeService();
            $isSent = $sendCodeService->sendNewUserEmailNotification($users, $toEmail, $startTime->format('d.m.Y H:i'), $endTime->format('d.m.Y H:i'));
            if(!$isSent){
                dispatch((new NewUsersNotificationsJob())->onQueue('user'))->delay(now()->addMinutes(15));
            }
        }
    }
}
