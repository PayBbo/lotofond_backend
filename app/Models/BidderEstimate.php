<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidderEstimate extends Model
{
    use HasFactory;
    protected $table = 'bidder_estimates';
    protected $fillable = [
        'user_id',
        'bidder_id',
        'comment',
        'estimate',
        'type'
    ];
    protected $casts = [
        'user_id'=>'integer',
        'bidder_id'=>'integer',
        'estimate'=>'integer'
    ];

    public function bidder(){

        return $this->belongsTo(Bidder::class, 'bidder_id');

    }

    public function user(){

        return $this->belongsTo(User::class, 'user_id');

    }
}
