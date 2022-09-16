<?php

namespace App\Http\Services;

use App\Exceptions\CustomExceptions\BaseException;
use App\Models\Notification;
use CodersStudio\SmsRu\Facades\SmsRu;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

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

    public function sendEmailNotification($toEmail, $subject, $value, $notification)
    {
        try {
            Mail::send([], [], function ($message) use ($toEmail, $subject, $value, $notification) {
                $html = "<p>$value</p>";
                $details = '';
                if (!is_null($notification->monitoring_id)) {
                    $category_icons = [
                        'accountsReceivable' => '/images/icons/accountsReceivable.png',
                        'agriculturaProperty' => '/images/icons/agriculturaProperty.png',
                        'equipment' => '/images/icons/equipment.png',
                        'obligations' => '/images/icons/obligations.png',
                        'other' => '/images/icons/other.png',
                        'productionLines' => '/images/icons/productionLines.png',
                        'realEstate' => '/images/icons/realEstate.png',
                        'tangibles' => '/images/icons/tangibles.png',
                        'transportAndEquipment' => '/images/icons/transportAndEquipment.png'
                    ];
                    $lots = $notification->notificationLots;
                    $details = '<table style="text-align: center"><thead><tr><td style="width: 5%">№</td><td style="width: 15%">Изображение</td><td style="width: 70%">Описание</td><td style="width: 10%">Ссылка</td></tr></thead><tbody>';
                    $i = 1;
                    foreach ($lots as $lot) {
                        if ($i >= 6) {
                            break;
                        }
                        if (count($lot->photos) > 0) {
                            $photo = $message->embed($lot->photos[0]['main']);
                        }else{
                            $category = $lot->categories()->first();
                            if(!is_null($category->parent_id)){
                                $photo = $message->embed(asset($category_icons[$category->parent()->title]));
                            }else{
                                $photo = $message->embed(asset($category_icons[$category->title]));
                            }
                        }
                        $desc = $lot->description;
                        $url = asset('lot/' . $lot->id);
                        $details .= "<tr><td>$i</td><td><img width='150px' height='117px' src='$photo' alt=''/></td><td>$desc</td><td><a href='$url'>Подробнее</a></td></tr>";
                        $i++;
                    }

                    if ($notification->notificationLots()->count() > 5) {
                        $url = asset('/monitoring');
                        $details .= "</tbody></table> <a href='$url'>Больше лотов по данному мониторингу</a>";
                    } else {
                        $details .= "</tbody></table>";
                    }
                }
                if (!is_null($notification->lot_id)) {
                    $description = $notification->lot->lot->description;
                    $url = asset('lot/' . $notification->lot->lot->id);
                    $details = "<p>$description</p><a href='$url'>Подробнее</a>";
                }
                $html .= $details . "<p>С уважением, Lotofond</p>";

                $message->from('bankr0t.t@yandex.ru', 'Lotofond');
                $message->to($toEmail);
                $message->subject($subject);
                $message->setBody($html, 'text/html');
            });
        } catch (Exception $e) {
            logger($e);
        }
    }
}
