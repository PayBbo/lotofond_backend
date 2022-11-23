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
    protected $is_lots_bot;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($html, $is_lots_bot = false)
    {
        $this->html = $html;
        $this->is_lots_bot = $is_lots_bot;
    }
    public function via($notifiable)
    {
        return ["telegram"];
    }

    public function toTelegram()
    {
        if($this->is_lots_bot){
            $chat_id = config('telegram.lots_chat_id');
        }else {
            $chat_id = config('telegram.chat_id');
        }
        logger($chat_id);
        $html = str_replace('<br>', '',  str_replace('</p>', '', str_replace('<p>', '', $this->html)));
        return TelegramMessage::create()
            ->to($chat_id)
            ->content($html)
            ->options(['parse_mode' => 'Html']);
    }
}
