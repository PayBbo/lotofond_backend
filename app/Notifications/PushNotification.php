<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Kutia\Larafirebase\Messages\FirebaseMessage;

class PushNotification extends Notification
{
    use Queueable;

    protected $title;
    protected $message;
    protected $deviceTokens;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title, $message, $deviceTokens)
    {
        $this->title = $title;
        $this->message = $message;
        $this->deviceTokens = $deviceTokens;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['firebase'];
    }

    public function toFirebase($notifiable)
    {
        return (new FirebaseMessage)
            ->withTitle($this->title)
            ->withBody($this->message)
            ->withPriority('high')->asMessage($this->deviceTokens);
    }

}
