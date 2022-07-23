<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotRegion extends Model
{
    use HasFactory;
    protected $table = 'lot_regions';
    protected $fillable = ['lot_id', 'region_id', 'is_debtor_region'];

    protected $casts = [
        'lot_id'=>'integer',
        'region_id'=>'integer',
        'is_debtor_region'=>'boolean'
    ];


}
