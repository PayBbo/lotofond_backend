<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiddingResult extends Model
{
    use HasFactory;

    protected $table = 'bidding_results';

    protected $fillable = [
        'trade_message_id',
        'end_price',
        'substantiation',
        'contract_number',
        'contract_date'
    ];

    protected $casts = [
        'trade_message_id'=>'integer',
        'contact_date'=>'datetime',
        'end_price'=>'decimal:2'
    ];

    public function tradeMessage()
    {
        return $this->belongsTo(TradeMessage::class);
    }

    public function biddingParticipants(){

        return $this->hasMany(BiddingParticipant::class);

    }
}
