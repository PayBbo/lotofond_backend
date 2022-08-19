<?php

namespace App\Models;

use App\Http\Services\PushNotificationService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'lot_id',
        'monitoring_id',
        'type_id',
        'value',
        'date',
        'is_seen',
        'message',
        'label',
        'platform_action'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'type_id' => 'integer',
        'lot_id' => 'integer',
        'date'=>'datetime',
        'is_seen'=>'boolean',
        'monitoring_id'=>'integer'

    ];

    public static function boot()
    {
        parent::boot();

        static::created(function ($notification) {
            $value = !is_null($notification->value) ? __('messages.' . $notification->message, ['value' => $notification->value]) :
                __('messages.' . $notification->message);

            $push = new PushNotificationService('Новое оповещение', $value, $notification->user_id, $notification->type->title);
            $push->sendPushNotification();
        });

    }

    public function lot()
    {
        return $this->belongsTo(FavouriteLot::class, 'lot_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(NotificationType::class);
    }

    public function monitoring()
    {
        return $this->belongsTo(Monitoring::class);
    }

}
