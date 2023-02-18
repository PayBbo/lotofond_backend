<?php

namespace App\Jobs;

use App\Exceptions\CustomExceptions\BaseException;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendApplication implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $html;
    protected $emails;
    protected $subject;

    /**
     * Get the middleware the job should pass through.
     *
     * @return array
     */
    public function middleware()
    {
        return [(new WithoutOverlapping($this->emails))->releaseAfter(random_int(60, 300))];
    }

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($html, $subject, $emails)
    {
        $this->html = $html;
        $this->subject = $subject;
        $this->emails = $emails;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $toEmail = $this->emails;
        $html = $this->html;
        $subject = $this->subject;

        Mail::send([], [], function ($message) use ($toEmail, $html, $subject) {
            $message->from('bankr0t.t@yandex.ru', 'LotoFond');
            $message->to($toEmail);
            $message->subject($subject);
            $message->setBody($html, 'text/html');
        });
    }
}
