<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidder extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'short_name',
        'inn',
        'ogrn',
        'ogrnip',
        'snils',
        'type',
        'address',
        'middle_name',
        'last_name',
        'phone',
        'email',
        'region_id',
        'debtor_category_id',
        'reg_num',
        'sro_reg_num',
        'sro_au_id',
        'reg_date'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'region_id' => 'integer',
        'debtor_category_id' => 'integer',
        'reg_date' => 'datetime',
        'sro_au_id' => 'integer',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function debtorCategory()
    {
        return $this->belongsTo(DebtorCategory::class, 'debtor_category_id');
    }

    public function sroAu()
    {
        return $this->belongsTo(SroAu::class);
    }

    public function auctions()
    {
        return $this->hasMany(Auction::class);
    }

    public function debtorAuctions()
    {
        return $this->hasMany(Auction::class, 'debtor_id');
    }

    public function arbitrManagerAuctions()
    {
        return $this->hasMany(Auction::class, 'arbitr_manager_id');
    }

    public function organizerAuctions()
    {
        return $this->hasMany(Auction::class, 'company_trade_organizer_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function registryNotifications()
    {
        return $this->hasMany(RegistryNotification::class);
    }

    public function types(){

        return $this->belongsToMany(Type::class, 'bidder_types');
    }

    public function biddingParticipants(){

        return $this->hasMany(BiddingParticipant::class);

    }

    public function debtorAuctionsWithLots()
    {
        return $this->hasMany(Auction::class, 'debtor_id')->whereHas('lots');
    }

    public function arbitrationManagerAuctionsWithLots()
    {
        return $this->hasMany(Auction::class, 'arbitr_manager_id')->whereHas('lots');
    }

    public function organizerAuctionsWithLots()
    {
        return $this->hasMany(Auction::class, 'company_trade_organizer_id')->whereHas('lots');
    }

    public function getNameForExport(){
        $name = $this->name;
        if(!is_null($this->last_name)){
            $name = $this->last_name . ' ' . $this->name . ' ' . $this->middle_name;
        }
        return $name;
    }
}
