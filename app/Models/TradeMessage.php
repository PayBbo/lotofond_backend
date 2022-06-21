<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeMessage extends Model
{
    use HasFactory;
    protected $table = 'trade_messages';
    protected $fillable = [
        'number',
        'lot_id',
        'value',
        'date',
        'param',
        'param_type'
    ];

    protected $casts = [
        'id' => 'integer',
        'lot_id' => 'integer',
        'date'=>'datetime'
    ];
    public function lot()
    {
        return $this->belongsTo(Lot::class);
    }

    public function lotFiles()
    {
        return $this->hasMany(LotFile::class);
    }

    public function lotApplications()
    {
        return $this->hasMany(LotApplication::class);
    }

    public function biddingResults()
    {
        return $this->hasMany(BiddingResult::class);
    }


}
