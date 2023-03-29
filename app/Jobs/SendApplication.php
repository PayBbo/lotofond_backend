<?php

namespace App\Jobs;

use App\Exceptions\CustomExceptions\BaseException;
use Carbon\Carbon;
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
    protected $isMailing;

    /**
     * Get the middleware the job should pass through.
     *
     * @return array
     */
   /* public function middleware()
    {
        return [(new WithoutOverlapping($this->emails))->releaseAfter(random_int(60, 300))];
    }*/

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($html, $subject, $emails, $isMailing=false)
    {
        $this->html = $html;
        $this->subject = $subject;
        $this->emails = $emails;
        $this->isMailing = $isMailing;
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
        $mail_from_name = config('mail.from.name');
        if($this->isMailing){
            logger('mailing!!!');
            $mailer = 'mailing_smtp';
            $mail_from_address = config('mail.from.mailing_address');
        }else{
            logger('user!!!');
            $mailer = 'user_smtp';
            $mail_from_address = config('mail.from.user_address');
        }
        logger($subject);
        logger('----------------------');
        try {
            Mail::mailer($mailer)->send([], [], function ($message) use ($toEmail, $html, $subject, $mail_from_address, $mail_from_name) {
                $message->from($mail_from_address, $mail_from_name);
                $message->to($toEmail);
                $message->subject($subject);
                $message->setBody($html, 'text/html');
            });
        }catch (Exception $exception){
            logger($exception->getMessage());
           // dispatch((new SendApplication($html, $subject, $toEmail, $this->isMailing))->onQueue('credentials')->delay(Carbon::now()->setTimezone('Europe/Moscow')->addHour()));
        }
    }
}
