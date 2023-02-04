<?php

namespace App\Models;

use App\Utilities\SortBuilder;
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
        'correspondence_address',
        'sro_au_id',
        'reg_date',
        'bankrupt_id'
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

    public function biddingVictories(){

        return $this->hasMany(BiddingParticipant::class)->where('is_winner', true);

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

    public function estimates()
    {
        return $this->hasMany(BidderEstimate::class);
    }

    public function rating($type){
        $count = $this->estimates->where('type', $type)->count();
        if($count > 0){
            $sum = $this->estimates->where('type', $type)->sum('estimate');
            return round($sum/$count, 1);
        }
        return 0.0;
    }

    public function getUserEstimate($type){
        if(auth()->guard('api')->check()) {
            return $this->estimates()->where(['user_id'=> auth()->id(), 'type'=>$type])->first();
        }
        return null;
    }

    public function scopeCustomSortBy($query, $request)
    {
        if (isset($request->sort) && isset($request->sort['direction']) && strlen((string)$request->sort['direction']) > 0
            && isset($request->sort['type']) && strlen((string)$request->sort['type']) > 0) {
            $namespace = 'App\Utilities\BidderSorts';
            $sort = new SortBuilder($query, $request->sort, $namespace);

            return $sort->apply();
        }
        return $query;
    }
}
