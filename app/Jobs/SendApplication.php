<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendApplication implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $username;
    protected $email;
    protected $phone;
    protected $socials;
    protected $lot;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($username, $email, $phone, $socials, $lot)
    {
        $this->username = $username;
        $this->email = $email;
        $this->phone = $phone;
        $this->socials = $socials;
        $this->lot = $lot;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $toEmail = $this->email;
        $html = "Пользователь $this->username оставил заявку на покупку без ЕЦП лота
            <a> $this->lot </a>
            <br>
            <strong>Почта: $this->email</strong>
             <br>
            <strong>Телефон: $this->phone</strong>
            <p>Социальные сети для ответа: $this->socials</p>";
        Mail::send([], [], function ($message) use ($toEmail, $html) {
            $message->from('bankr0t.t@yandex.ru', 'BankrotMP');
            $message->to($toEmail);
            $message->subject('Новая заявка на покупку без ЕЦП');
            $message->setBody($html, 'text/html');
        });
    }
}
