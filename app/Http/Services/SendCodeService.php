<?php

namespace App\Http\Services;

use App\Exceptions\CustomExceptions\BaseException;
use App\Jobs\SendApplication;
use App\Models\Application;
use App\Models\Contact;
use App\Models\Lot;
use App\Models\Notification;
use App\Models\Tariff;
use App\Models\User;
use App\Notifications\ApplicationTelegramNotification;
use Carbon\Carbon;
use CodersStudio\SmsRu\Facades\SmsRu;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class SendCodeService
{
    public function sendEmailCode($toEmail, $code)
    {
        try {
            $html = "Здравствуйте, подтвердите Ваш адрес электронной почты для Lotofond с помощью кода проверки из данного сообщения
            <strong> $code </strong>
            <p>Если Вы не запрашивали код подтверждения для выполнения операции в Lotofond, проигнорируйте данное сообщение.</p>";
            Mail::mailer('user_smtp')->send([], [], function ($message) use ($toEmail, $html) {
                $message->from(config('mail.from.user_address'), config('mail.from.name'));
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
            Mail::mailer('user_smtp')->send([], [], function ($message) use ($toEmail, $html) {
                $message->from(config('mail.from.user_address'), config('mail.from.name'));
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


    public function sendPhoneCall($toPhone)
    {
        $client = new Client();
        $response = $client->request('GET', 'https://sms.ru/code/call',
            [
                RequestOptions::QUERY => [
                    "phone" => $toPhone, // номер телефона пользователя
                    "ip" => request()->getClientIp(), // ip адрес пользователя
                    "api_id" => config("sms-ru.api_key")
                ]
            ]);
        $result = json_decode($response->getBody(), true);
        if ($result['status'] != 'OK') {
            throw new BaseException("ERR_SEND_MESSAGE_FAILED", 550, __('validation.message_err'));
        }
        return $result['code'];
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
            Mail::mailer('user_smtp')->send([], [], function ($message) use ($toEmail, $subject, $value, $notification) {
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
                        } else {
                            $category = $lot->categories()->first();
                            if (!is_null($category->parent_id)) {
                                $photo = $message->embed(asset($category_icons[$category->parent()->title]));
                            } else {
                                $photo = $message->embed(asset($category_icons[$category->title]));
                            }
                        }
                        $desc = mb_strimwidth($lot->description, 0, 100, "...");
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

                $message->from(config('mail.from.user_address'), config('mail.from.name'));
                $message->to($toEmail);
                $message->subject($subject);
                $message->setBody($html, 'text/html');
            });
        } catch (Exception $e) {
            logger($e);
        }
    }

    public function sendApplicationToManager($application)
    {
        try {
            $serviceName = $application->tariff->getTranslation('title', 'ru');
            $lot = URL::to('/lot/' . $application->lot_id);
            $lotDesc = mb_strimwidth(Lot::find($application->lot_id)['description'], 0, 250, "...");
            $html = $application->lot_id ? "Пользователь $application->username оставил заявку на покупку услуги - $serviceName.
<p><strong>Описание лота:</strong>
$lotDesc</p>
<a href='$lot'>Ссылка на лот </a>" : "Пользователь $application->username оставил заявку на покупку услуги - $serviceName.";
            $html .= "<br>
<strong>Почта: $application->email</strong>";
            if (!is_null($application->phone)) {
                $html .= "<br>
<strong>Телефон: $application->phone</strong>";
            }
            if (!is_null($application->for_answer)) {
                $html .= "
<p>Социальные сети для ответа: $application->for_answer</p>";
            }
            if (isset($application->answer_date) && strlen($application->answer_date) > 0) {
                $dateForCallback = Carbon::parse($application->answer_date)->format('d.m.Y H:i');
                $html .= "
<p>Дата и время для ответа: $dateForCallback</p>";
            }
            if (!is_null($application->payment_id)) {
                $paymentId = $application->payment->payment_id;
                $paymentStatus = __('payments.' . $application->payment->status);
                $html .= "
<p>Статус транзакции № $paymentId - $paymentStatus </p>";
            }

            $subject = 'Новая заявка на покупку услуги - ' . $serviceName;

            $emails = Contact::where('tariff_id', $application->tariff_id)->pluck('contact')->toArray();

            if (count($emails) > 0) {
                dispatch((new SendApplication($html, $subject, $emails))->onQueue('credentials'));
            }
            $token = config('telegram.bot_token');
            $chat_id = config('telegram.admin_chat_id');
            \Illuminate\Support\Facades\Notification::route('telegram', $token)
                ->notify(new ApplicationTelegramNotification($html, $chat_id));
        } catch (Exception $e) {
            throw new BaseException("ERR_SEND_MESSAGE_FAILED", 550, __('validation.message_err'));
        }
    }

    public function sendQuestionToManager($application)
    {
        try {
            $html = "Пользователь $application->username  задал вопрос по теме:
<p>$application->topic</p>
<p>$application->question</p>
<strong>Почта: $application->email</strong>";
            if ($application->files) {
                foreach ($application->files as $file) {
                    $path = URL::to('storage/' . $file);
                    $html .= " <br>
<a href='$path'>Прикрепленный файл </a>";
                }
            }
            $subject = $application->tariff->getTranslation('title', 'ru');
            $emails = Contact::where('tariff_id', $application->tariff_id)->pluck('contact')->toArray();
            if (count($emails) > 0) {
                dispatch((new SendApplication($html, $subject, $emails))->onQueue('credentials'));
            }
            $token = config('telegram.bot_token');
            $chat_id = config('telegram.admin_chat_id');
            \Illuminate\Support\Facades\Notification::route('telegram', $token)
                ->notify(new ApplicationTelegramNotification($html, $chat_id));
        } catch (Exception $e) {
            throw new BaseException("ERR_SEND_MESSAGE_FAILED", 550, __('validation.message_err'));
        }
    }

    public function sendContactsToManager($application)
    {
        try {
            if (!is_null($application->email)) {
                $communication = 'Почта для ответа: ' . $application->email;
            } else {
                $communication = 'Телефон для ответа: ' . $application->phone;
            }
            $html = "У Вас новый вопрос:
<p>$application->question</p>
<strong>$communication</strong>";
            $subject = $application->tariff->getTranslation('title', 'ru');
            $emails = Contact::where('tariff_id', $application->tariff_id)->pluck('contact')->toArray();
            if (count($emails) > 0) {
                dispatch((new SendApplication($html, $subject, $emails))->onQueue('credentials'));
            }
            $token = config('telegram.bot_token');
            $chat_id = config('telegram.admin_chat_id');
            \Illuminate\Support\Facades\Notification::route('telegram', $token)
                ->notify(new ApplicationTelegramNotification($html, $chat_id));
        } catch (Exception $e) {
            throw new BaseException("ERR_SEND_MESSAGE_FAILED", 550, __('validation.message_err'));
        }
    }

    public function sendEGRNStatement($application, $fileLink)
    {
        logger('sendEGRNStatement id ='.$application->id);
        try {
            $lotUrl = URL::to('/lot/' . $application->lot_id);
            $html = "<p>Добрый день!</p>
<p>Ваша заявка № <strong>$application->id</strong> на получение отчета ЕГРН для кадастрового номера <strong>$application->cadastral_number</strong> в <a href='$lotUrl'>лоте</a> готова!</p>
<a href='$fileLink'>Ссылка для скачивания файла отчета ЕГРН</a>
<p>С уважением, Lotofond</p>";
            $subject = 'Ответ на заявку "Отчет ЕГРН"';
            $toEmail = $application->email;
            Mail::mailer('user_smtp')->send([], [], function ($message) use ($toEmail, $html, $subject) {
                $message->from(config('mail.from.user_address'), config('mail.from.name'));
                $message->to($toEmail);
                $message->subject($subject);
                $message->setBody($html, 'text/html');
            });
            logger('email send success');
        } catch (Exception $e) {
            logger($e);
        }
    }


    public function sendNewUserEmailNotification($users, $toEmail, $startTime, $endTime)
    {
        try {

            $subject = 'Новые пользователи в Lotofond';
            $html = "<p>В период с $startTime по $endTime в Lotofond зарегистрировались пользователи:</p>";
            Mail::mailer('user_smtp')->send([], [], function ($message) use ($toEmail, $subject, $users, $html) {
                $details = '<table style="text-align: center"><thead style="line-height: 3"><tr><td style="width: 5%">№</td><td style="width: 35%">ФИО</td><td style="width: 30%">Регион</td><td style="width: 30%">Дата регистрации</td></tr></thead><tbody>';
                foreach ($users as $key=>$user) {
                    if(is_null( $user->surname) && is_null($user->name)){
                        $fio = 'Данные не заполнены';
                    }else {
                        $fio = $user->surname . ' ' . $user->name;
                        if (!is_null($user->middle_name)) {
                            $fio .= ' ' . $user->middle_name;
                        }
                    }
                    $region = is_null($user->region_id) ? 'Данные не заполнены' : $user->region->title;
                    $regDate = Carbon::parse($user->email_verified_at)->format('d.m.Y H:i');
                    $key+=1;
                    $details .= "<tr style='line-height: 3'><td>$key</td><td>$fio</td><td>$region</td><td>$regDate</td></tr>";
                }
                $details .= "</tbody></table>";

                $html .= $details . "<p>С уважением, Lotofond</p>";

                $message->from(config('mail.from.user_address'), config('mail.from.name'));
                $message->to($toEmail);
                $message->subject($subject);
                $message->setBody($html, 'text/html');
            });
            return true;
        } catch (Exception $e) {
            logger($e);
            return false;
        }
    }
}
