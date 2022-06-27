<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradePlace extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'owner_name',
        'inn',
        'site'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer'
    ];

    public function auctions()
    {
        return $this->hasMany(Auction::class);
    }

    public function auctionsWithLots()
    {
        return $this->hasMany(Auction::class)->whereHas('lots');
    }
}
