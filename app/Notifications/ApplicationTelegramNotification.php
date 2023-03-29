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
    protected $chat_id;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($html, $chat_id=null)
    {
        $this->html = $html;
        $this->chat_id =  config('telegram.chat_id');
        if(!is_null($chat_id)){
            $this->chat_id = $chat_id;
        }

    }
    public function via($notifiable)
    {
        return ["telegram"];
    }

    public function toTelegram()
    {
        $html = str_replace('<br>', '',  str_replace('</p>', '', str_replace('<p>', '', $this->html)));
        return TelegramMessage::create()
            ->to($this->chat_id)
            ->content($html)
            ->options(['parse_mode' => 'Html']);
    }
}
