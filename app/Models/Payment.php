<?php

namespace App\Models;

use App\Http\Services\ReestrApiService;
use App\Http\Services\SendCodeService;
use App\Jobs\SendApplication;
use App\Notifications\ApplicationTelegramNotification;
use Carbon\Carbon;
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
        'user_id' => 'integer',
        'sum' => 'float',
        'tariff_id' => 'integer',
        'finished_at' => 'timestamp',
        'is_confirmed' => 'boolean'
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
            if ($payment->status == 'Settled' && $payment->is_confirmed) {
                $application = Application::where('payment_id', $payment->id)->first();
                if ($application) {
                    if ($payment->tariff->code == 'purchaseInstructions') {
                        $sendEmail = new SendCodeService();
                        $sendEmail->sendApplicationToManager($application);
                    }
                    if ($payment->tariff->code == 'receiptEGRN') {
                        if (!is_null($application->cadastral_number)) {
                            $reestrApi = new ReestrApiService();
                            $reestrApi->createEgrnOrder($application);
                        }
                    }
                }
            }
        });

    }


}
