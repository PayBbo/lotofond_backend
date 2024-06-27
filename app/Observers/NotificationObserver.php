<?php

namespace App\Observers;

use App\Http\Services\PushNotificationService;
use App\Http\Services\SendCodeService;
use App\Models\Notification;
use App\Models\User;

class NotificationObserver
{
    /**
     * Handle the Notification "created" event.
     *
     * @param  \App\Models\Notification  $notification
     * @return void
     */
    public function created(Notification $notification)
    {
        if( $notification->type->title == 'favourite' ||  $notification->type->title == 'platform') {
            try {
                if ($notification->type->title == 'favourite') {
                    $title = $notification->lot->favourite->title;
                    $value = __('messages.' . $notification->message, ['value' => $notification->value]);
                    $subtitle = 'Изменение лота';
                } /*elseif ($notification->type->title == 'monitoring') {
                    $title = $notification->monitoring->title;
                    $value = __('messages.' . $notification->message, ['value' => $notification->value]);
                    $subtitle = 'Новые лоты в мониторинге';
                } */ else {
                    if (is_null($notification->application_id)) {
                        $title = is_null($notification->title) ? 'Новое оповещение' : __('messages.' . $notification->label);
                        $subtitle = '';
                        $value = !is_null($notification->value) ? __('messages.' . $notification->message, ['value' => $notification->value]) :
                            __('messages.' . $notification->message);
                    } else {
                        $title = __('messages.' . $notification->label, ['value' => $notification->application->tariff->title, 'value2' => $notification->application->lot_id]);
                        $subtitle = '';
                        $value = !is_null($notification->value) ? __('messages.' . $notification->message, ['value' => $notification->value]) :
                            __('messages.' . $notification->message);
                    }
                }
                $push = new PushNotificationService($title, $value, $notification->user_id, $notification->type->title);
                $push->sendPushNotification();
                $user = User::find($notification->user_id);
                if (!is_null($user->email) && $user->not_to_email && $notification->type->title != 'platform') {
                    $sendNotification = new SendCodeService();
                    $sendNotification->sendEmailNotification($user->email, $title . '. ' . $subtitle, $value, $notification);
                }
            }catch (\Exception $exception){
                logger('SEND NOTIFICATION ERROR');
                logger($exception);
            }
        }
    }

    /**
     * Handle the Notification "updated" event.
     *
     * @param  \App\Models\Notification  $notification
     * @return void
     */
    public function updated(Notification $notification)
    {
        //
    }

    /**
     * Handle the Notification "deleted" event.
     *
     * @param  \App\Models\Notification  $notification
     * @return void
     */
    public function deleted(Notification $notification)
    {
        //
    }

    /**
     * Handle the Notification "restored" event.
     *
     * @param  \App\Models\Notification  $notification
     * @return void
     */
    public function restored(Notification $notification)
    {
        //
    }

    /**
     * Handle the Notification "force deleted" event.
     *
     * @param  \App\Models\Notification  $notification
     * @return void
     */
    public function forceDeleted(Notification $notification)
    {
        //
    }
}
