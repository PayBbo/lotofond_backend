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
            $html = "Здравствуйте, подтвердите Ваш адрес электронной почты для Lotofond с помощью кода проверки из данного сообщения
            <strong> $code </strong>
            <p>Если Вы не запрашивали код подтверждения для выполнения операции в Lotofond, проигнорируйте данное сообщение.</p>";
            Mail::send([], [], function ($message) use ($toEmail, $html) {
                $message->from('bankr0t.t@yandex.ru', 'Lotofond');
                $message->to($toEmail);
                $message->subject('Подтверждение электронной почты');
                $message->setBody($html, 'text/html');
            });
        } catch (Exception $e) {
            throw new BaseException("ERR_SEND_MESSAGE_FAILED", 550, __('validation.message_err'));
        }
    }

    public function sendEmailWarning($toEmail, $newEmail)
    {
        try {
            $html = "Здравствуйте, уведомляем Вас, что ваша электронная почта в аккаунте Lotofond через 14 дней будет изменена на
            <strong> $newEmail</strong>
            <p>Если Вы не запрашивали выполнение данной операции в Lotofond, отмените запрос на смену почты в личном кабинете.</p>";
            Mail::send([], [], function ($message) use ($toEmail, $html) {
                $message->from('bankr0t.t@yandex.ru', 'Lotofond');
                $message->to($toEmail);
                $message->subject('Уведомление о смене электронной почты');
                $message->setBody($html, 'text/html');
            });
        } catch (Exception $e) {
            throw new BaseException("ERR_SEND_MESSAGE_FAILED", 550, __('validation.message_err'));
        }
    }

    public function sendPhoneCode($toPhone, $code)
    {
        $isSent = SmsRu::send($toPhone, 'Ваш код подтверждения в Lotofond: ' . $code . ' Если Вы не запрашивали код подтверждения, проигнорируйте данное сообщение.');
        if (!$isSent) {
            throw new BaseException("ERR_SEND_MESSAGE_FAILED", 550, __('validation.message_err'));
        }
    }

    public function sendPhoneWarning($toPhone, $newPhone)
    {
        $isSent = SmsRu::send($toPhone, 'Здравствуйте, уведомляем Вас, что ваш номер телефона в аккаунте Lotofond через 14 дней будет изменен на ' . $newPhone);
        if (!$isSent) {
            throw new BaseException("ERR_SEND_MESSAGE_FAILED", 550, __('validation.message_err'));
        }
    }

    public function sendEmailNotification($toEmail, $text)
    {
        try {
            $html = "<p>Здравствуйте!</p> <p>У Вас новое оповещение!</p>
            <p>$text</p>
            <p>С уважением, Lotofond</p>";
            Mail::send([], [], function ($message) use ($toEmail, $html) {
                $message->from('bankr0t.t@yandex.ru', 'Lotofond');
                $message->to($toEmail);
                $message->subject('У Вас новое оповещение');
                $message->setBody($html, 'text/html');
            });
        } catch (Exception $e) {
            logger($e);
        }
    }
}
