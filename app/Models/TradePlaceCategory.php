<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TradePlaceCategory extends Model
{
    use HasFactory;
    use HasTranslations;

    public $translatable = ['title'];

    protected $table = 'trade_place_categories';
    protected $fillable = ['title'];

    public function tradePlaces(){
        return $this->hasMany(TradePlace::class);
    }
}
