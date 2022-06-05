<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArbitrManager extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'inn',
        'reg_num',
        'sro_reg_num',
        'ogrnip',
        'region_id',
        'arbitr_manager_id',
        'date_of_last_modifier',
        'sro_au_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'region_id' => 'integer',
        'arbitr_manager_id'=>'integer',
        'date_of_last_modifier' => 'datetime',
        'sro_au_id'=> 'integer'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function sroAu()
    {
        return $this->belongsTo(SroAu::class);
    }

    public function auctions()
    {
        return $this->hasMany(Auction::class);
    }

  /*  public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function registryNotifications()
    {
        return $this->hasMany(RegistryNotification::class);
    }*/
}
