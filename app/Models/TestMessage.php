<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestMessage extends Model
{
    use HasFactory;

    protected $table = 'test_messages';
    protected $fillable = [
        'lot_id',
        'message_id',
        'start_price',
        'auction_step',
        'auction_step_unit',
        'advance',
        'advance_step_unit',
        'price_reduction',
        'organizer_fio',
        'arbitr_fio',
        'organizer_name',
        'arbitr_name',
        'sro',
        'text',
        'organizer',
        'arbitration_manager',
        'trade_site'
    ];
    protected $casts = [
      'organizer'=>'array',
      'arbitration_manager'=>'array'
    ];
}
