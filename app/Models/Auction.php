<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_efrsb',
        'id_external',
        'trade_id',
        'publish_date',
        'debtor_id',
        'arbitr_manager_id',
        'company_trade_organizer_id',
        'trade_place_id',
        'auction_type_id',
        'result_date',
        'event_start_date',
        'event_end_date',
        'application_start_date',
        'application_end_date',
        'price_form',
        'case_number',
        'court',
        'date_publish_smi',
        'date_publish_efir',
        'guid',
        'application_rules'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'publish_date' => 'datetime',
        'debtor_id' => 'integer',
        'arbitr_manager_id' => 'integer',
        'company_trade_organizer_id' => 'integer',
        'trade_place_id' => 'integer',
        'auction_type_id' => 'integer',
        'event_start_date'=>'datetime',
        'event_end_date'=>'datetime',
        'application_start_date'=>'datetime',
        'application_end_date'=>'datetime',
        'result_date' =>'datetime',
        'date_publish_smi'=>'datetime',
        'date_publish_efir'=>'datetime',
    ];

    public function debtor()
    {
        return $this->belongsTo(Bidder::class, 'debtor_id');
    }

    public function arbitrationManager()
    {
        return $this->belongsTo(Bidder::class, 'arbitr_manager_id');
    }

    public function tradePlace()
    {
        return $this->belongsTo(TradePlace::class, 'trade_place_id');
    }

    public function companyTradeOrganizer()
    {
        return $this->belongsTo(Bidder::class, 'company_trade_organizer_id');
    }

    public function auctionType()
    {
        return $this->belongsTo(AuctionType::class);
    }

    public function lots()
    {
        return $this->hasMany(Lot::class);
    }
}
