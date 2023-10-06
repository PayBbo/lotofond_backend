<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Application extends Model
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
        'email',
        'username',
        'phone',
        'for_answer',
        'answer_date',
        'topic',
        'question',
        'files',
        'cadastral_number',
        'status',
        'tariff_id',
        'payment_id',
        'format'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'lot_id' => 'integer',
        'tariff_id'=> 'integer',
        'payment_id'=> 'integer',
        'answer_date' => 'timestamp',
        'is_answered'=>'boolean',
        'files'=>'array'
    ];

    public static function boot()
    {
        parent::boot();

        static::updated(function ($application) {
            if (!is_null($application->user_id) && $application->tariff->code != 'newQuestion') {
                $notification = new Notification();
                $notification->user_id = $application->user_id;
                $notification->date = Carbon::now()->setTimezone('Europe/Moscow');
                $notification->type_id = 1;
                $notification->application_id = $application->id;
                $notification->platform_action = 'info';
                if($application->status == 'inProgress') {
                    $notification->label = 'applicationProcessTitle';
                    $notification->message = 'applicationProcessBody';
                }
                if ($application->status == 'completed') {
                    $notification->label = 'applicationAnswerTitle';
                    $notification->message = 'applicationAnswerBody';
                }
                $notification->save();
            }
        });

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lot()
    {
        return $this->belongsTo(Lot::class);
    }

    public function tariff()
    {
        return $this->belongsTo(Tariff::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function getFiles()
    {
        $files = [];
        if(!is_null($this->files)) {
            foreach ($this->files as $file) {
                $files[] = URL::to('/').'/'.$file;
            }
        }
        return $files;
    }
}
