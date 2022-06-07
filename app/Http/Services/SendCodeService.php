<?php

namespace App\Http\Services;

use App\Exceptions\CustomExceptions\BaseException;
use CodersStudio\SmsRu\Facades\SmsRu;
use Exception;
use Illuminate\Support\Facades\Mail;

class SendCodeService
{
    public function sendEmailCode($toEmail, $code)
    {
        try {
            $html = "Здравствуйте, подтвердите Ваш адрес электронной почты для приложения BankrotMP с помощью кода проверки из данного сообщения
            <strong> $code </strong>
            <p>Если Вы не запрашивали код подтверждения для выполнения операции в BankrotMP, проигнорируйте данное сообщение.</p>";
            Mail::send([], [], function ($message) use ($toEmail, $html) {
                $message->from('bankr0t.t@yandex.ru', 'BankrotMP');
                $message->to($toEmail);
                $message->subject('Подтверждение электронной почты');
                $message->setBody($html, 'text/html');
            });
        } catch (Exception $e) {
            throw new BaseException("ERR_SEND_MESSAGE_FAILED", 550, "Message can't be sent to ".$toEmail);
        }
    }

    public function sendPhoneCode($toPhone, $code){
        $isSent = SmsRu::send($toPhone, 'Ваш код подтверждения в BankrotMP: '.$code.' Если Вы не запрашивали код подтверждения, проигнорируйте данное сообщение.');
        if(!$isSent){
            throw new BaseException("ERR_SEND_MESSAGE_FAILED", 550, "Message can't be sent to ".$toPhone);
        }
    }
}
