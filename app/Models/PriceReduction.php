<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceReduction extends Model
{
    use HasFactory;
    protected $table = 'price_reductions';
    protected $fillable = [
        'lot_id',
        'price',
        'start_time',
        'end_time',
        'deposit',
        'percent',
        'is_system'
    ];
    protected $casts = [
        'lot_id'=>'integer',
        'price'=>'integer',
        'start_time'=>'datetime',
        'end_time'=>'datetime',
        'deposit'=>'float',
        'percent'=>'integer',
        'is_system'=>'boolean'
    ];

    public function lot(){

        return $this->belongsTo(Lot::class, 'lot_id');

    }
}
