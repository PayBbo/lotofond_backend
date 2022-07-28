<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
        'device_tokens'
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
        'device_tokens'=>'array'
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
        return $this->belongsToMany(Lot::class, 'fixed_lots');
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

}
