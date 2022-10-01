<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;


class ApplicationTelegramNotification extends Notification
{
    use Queueable;

    protected $html;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($html)
    {
        $this->html = $html;
    }
    public function via($notifiable)
    {
        return ["telegram"];
    }

    public function toTelegram()
    {
        $chat_id = config('telegram.chat_id');
        $html = str_replace('<br>', '',  str_replace('</p>', '', str_replace('<p>', '', $this->html)));
        return TelegramMessage::create()
            ->to($chat_id)
            ->content($html)
            ->options(['parse_mode' => 'Html']);
    }
}
