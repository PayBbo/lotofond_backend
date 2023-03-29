<?php

namespace App\Observers;

use App\Models\User;
use App\Models\VerifyAccount;
use App\Notifications\ApplicationTelegramNotification;
use Carbon\Carbon;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $token = config('telegram.bot_token');
        $chat_id = config('telegram.admin_chat_id');
        if(is_null( $user->surname) && is_null($user->name)){
            $fio = 'Данные не заполнены';
        }else {
            $fio = $user->surname . ' ' . $user->name;
            if (!is_null($user->middle_name)) {
                $fio .= ' ' . $user->middle_name;
            }
        }
        $region = is_null($user->region_id) ? 'Данные не заполнены' : $user->region->title;
        $regDate = Carbon::parse($user->email_verified_at)->format('d.m.Y H:i');
        $html = "Новый пользователь в Lotofond!
<strong>ФИО:</strong> $fio
<strong>Регион:</strong> $region
<strong>Дата регистрации:</strong> $regDate";
        \Illuminate\Support\Facades\Notification::route('telegram', $token)
            ->notify(new ApplicationTelegramNotification($html, $chat_id));
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        if (VerifyAccount::where('value', $user->email)->exists()) {
            VerifyAccount::where('value', $user->email)->delete();
        }else if(VerifyAccount::where('phone', $user->phone)->exists()){
            VerifyAccount::where('phone', $user->phone)->delete();
        }
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
