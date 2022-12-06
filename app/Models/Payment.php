<?php

namespace App\Models;

use App\Jobs\SendApplication;
use App\Notifications\ApplicationTelegramNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';
    protected $fillable = [
        'user_id',
        'payment_id',
        'sum',
        'tariff_id',
        'finished_at',
        'is_confirmed',
        'status',
        'token'
    ];

    protected $casts = [
        'user_id'=>'integer',
        'sum'=>'float',
        'tariff_id' => 'integer',
        'finished_at' => 'timestamp',
        'is_confirmed'=>'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tariff()
    {
        return $this->belongsTo(\App\Models\Tariff::class);
    }

    public static function boot()
    {
        parent::boot();

        static::updated(function ($payment) {
           if($payment->status == 'Settled' && $payment->is_confirmed){
               if($payment->tariff->code == 'purchaseInstructions') {
                   $application = Application::where('payment_id', $payment->id)->first();
                   if ($application) {
                       $lot = URL::to('/lot/' . $application->lot_id);
                       $lotDesc = mb_strimwidth(Lot::find($application->lot_id)['description'], 0, 250, "...");
                       $user = User::find($application->user_id);
                       $username = $user->surname . ' ' . $user->name;
                       $serviceName = $payment->tariff->getTranslation('title', 'ru');
                       $email = $application->email;
                       $paymentId = $payment->payment_id;
                       $paymentStatus = __('payments.'.$payment->status);
                       $html = "<p>Пользователь $username оставил заявку на покупку услуги - $serviceName.</p>
<strong>Почта: $email</strong>
<p>Статус транзакции № $paymentId - $paymentStatus </p>
<strong>Описание лота:</strong>
<p>$lotDesc</p>
<a href='$lot'>Ссылка на лот </a>";
                       $subject = 'Новая заявка на покупку услуги - ' . $serviceName;
                       $emails = Contact::where('tariff_id', $payment->tariff->id)->pluck('contact')->toArray();
                       if (count($emails) > 0) {
                           dispatch((new SendApplication($html, $subject, $emails))->onQueue('credentials'));
                       }
                       $token = config('telegram.bot_token');
                       Notification::route('telegram', $token)
                           ->notify(new ApplicationTelegramNotification($html));
                   }
               }
           }
        });

    }


}
