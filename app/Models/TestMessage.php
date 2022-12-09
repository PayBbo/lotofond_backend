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
        'price_reduction',
        'text',
        'description',
        'change_desc',
        'period',
        'min_price',
        'price_red_json'

    ];
    protected $casts = [
      'price_red_json'=>'array'
    ];
}
