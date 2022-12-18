<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'surname',
        'phone',
        'middle_name',
        'not_from_favourite',
        'not_from_monitoring',
        'not_settings',
        'name',
        'email',
        'password',
        'not_to_email',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'not_settings'=>'json',
        'not_to_email'=>'boolean',
        'not_from_favourite' =>'boolean',
        'not_from_monitoring' =>'boolean'
    ];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function favourites()
    {
        return $this->hasMany(Favourite::class);
    }

    public function monitorings()
    {
        return $this->hasMany(Monitoring::class);
    }

    public function fixedLots()
    {
        return $this->belongsToMany(Lot::class, 'fixed_lots')->withPivot('created_at');;
    }

    public function seenLots()
    {
        return $this->belongsToMany(Lot::class, 'seen_lots');
    }

    public function hiddenLots()
    {
        return $this->belongsToMany(Lot::class, 'hidden_lots');
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public static function boot()
    {
        parent::boot();

        static::updated(function ($user) {
            if (VerifyAccount::where('value', $user->email)->exists()) {
                VerifyAccount::where('value', $user->email)->delete();
            }else if(VerifyAccount::where('phone', $user->phone)->exists()){
                VerifyAccount::where('phone', $user->phone)->delete();
            }

        });

    }

    public function findForPassport($username)
    {

        if (strpos($username, ' ') !== false) {
            $data = explode(" ", $username);
            if (SocialAccount::where(['provider_id' => $data[0], 'provider' => $data[1]])->exists()) {
                $social = SocialAccount::where(['provider_id' => $data[0], 'provider' => $data[1]])->first();
                return $this->where('id', $social->user_id)->first();
            }
        }

        if ($this->where('email', $username)->exists()) {
            return $this->where('email', $username)->first();
        }
        if ($this->where('phone', $username)->exists()) {
            return $this->where('phone', $username)->first();
        }


    }

    public function lotFiles()
    {
        return $this->hasMany(LotFile::class);
    }

    public function estimates()
    {
        return $this->hasMany(BidderEstimate::class);
    }

    public function socialAccount()
    {
        return $this->HasMany(\App\Models\SocialAccount::class);
    }

    public function deviceTokens()
    {
        return $this->HasMany(\App\Models\DeviceToken::class);
    }

    public function changeCredentials(){
        return $this->hasMany(ChangeCredentials::class);
    }

    public function payments()
    {
        return $this->hasMany(\App\Models\Payment::class);
    }

    public function tariff()
    {
        return $this->hasOne(Payment::class)
            ->where('tariff_id', '!=', null)
            ->where('is_confirmed', true)
            ->where('status', 'Settled')
            ->where('finished_at', '>=', Carbon::now()->setTimezone('Europe/Moscow'))
            ->latest();
    }

    public function userTariffs()
    {
        return $this->hasMany(Payment::class)
            ->where('tariff_id', '!=', null)
            ->where('is_confirmed', true)
            ->where('status', 'Settled')
            ->where('finished_at', '>=', Carbon::now()->setTimezone('Europe/Moscow'));
    }

}
