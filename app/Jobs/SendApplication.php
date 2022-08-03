<?php

namespace App\Jobs;

use App\Exceptions\CustomExceptions\BaseException;
use Exception;
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

    protected $html;
    protected $email;
    protected $subject;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($html, $subject, $email)
    {
        $this->html = $html;
        $this->subject = $subject;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $toEmail = $this->email;
        $html = $this->html;
        $subject = $this->subject;
        try {
            Mail::send([], [], function ($message) use ($toEmail, $html, $subject) {
                $message->from('bankr0t.t@yandex.ru', 'LotoFond');
                $message->to($toEmail);
                $message->subject($subject);
                $message->setBody($html, 'text/html');
            });
        }catch (Exception $e) {
            throw new BaseException("ERR_SEND_MESSAGE_FAILED", 550, __('validation.message_err'));
        }
    }
}
