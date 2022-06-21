<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotApplication extends Model
{
    use HasFactory;

    protected $table = 'lot_applications';

    protected $fillable = [
        'entry_count',
        'accept_count',
        'result',
        'cause_of_refuse',
        'trade_message_id'
    ];

    protected $casts = [
        'entry_count'=>'integer',
        'accept_count' => 'integer',
        'trade_message_id' => 'integer'
    ];

    public function tradeMessage()
    {
        return $this->belongsTo(TradeMessage::class);
    }


}
