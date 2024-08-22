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
        'site',
        'trade_place_category_id',
        'email',
        'code'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'trade_place_category_id'=>'integer'
    ];

    public function auctions()
    {
        return $this->hasMany(Auction::class);
    }

    public function auctionsWithLots()
    {
        return $this->hasMany(Auction::class)->whereHas('lots');
    }

    public function getNote(){
        $note = null;
        if(auth()->guard('api')->check() && Note::where(['user_id'=>auth()->guard('api')->id(),
                'item_type'=>'tradePlace', 'item_id'=>$this->id])->exists() ){
            $note = Note::where(['user_id'=>auth()->guard('api')->id(),
                'item_type'=>'tradePlace', 'item_id'=>$this->id])->first()->only('id', 'title', 'date');
        }
        return $note;
    }

    public function tradePlaceCategory(){
        return $this->belongsTo(TradePlaceCategory::class);
    }
}
