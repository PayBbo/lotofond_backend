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
        'number',
        'publish_date',
        'debitor_id',
        'arbitration_manager_id',
        'organizer_id',
        'trading_platform_id',
        'auction_type_id',
        'event_period',
        'application_period',
        'result_date',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'publish_date' => 'timestamp',
        'debitor_id' => 'integer',
        'arbitration_manager_id' => 'integer',
        'organizer_id' => 'integer',
        'trading_platform_id' => 'integer',
        'auction_type_id' => 'integer',
        'event_period' => 'array',
        'application_period' => 'array',
        'result_date' => 'timestamp',
    ];

    public function debitor()
    {
        return $this->belongsTo(Bidder::class, 'debitor_id');
    }

    public function arbitrationManager()
    {
        return $this->belongsTo(Bidder::class, 'arbitration_manager_id');
    }

    public function tradingPlatform()
    {
        return $this->belongsTo(Bidder::class, 'trading_platform_id');
    }

    public function organizer()
    {
        return $this->belongsTo(Bidder::class, 'organizer_id');
    }

    public function auctionType()
    {
        return $this->belongsTo(AuctionType::class);
    }

    public function lots()
    {
        return $this->belongsToMany(Lot::class);
    }
}
