<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiddingParticipant extends Model
{
    use HasFactory;

    protected $table = 'bidding_participants';

    protected $fillable = [
        'bidding_result_id',
        'bidder_id',
        'is_winner',
        'is_buyer'
    ];

    protected $casts = [
        'is_winner'=>'boolean',
        'is_buyer'=>'boolean'
    ];

    public function bidder(){

        return $this->belongsTo(Bidder::class, 'bidder_id');

    }

    public function biddingResult(){

        return $this->belongsTo(BiddingResult::class, 'bidding_result_id');

    }


}
