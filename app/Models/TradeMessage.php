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
        'date'
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
}
