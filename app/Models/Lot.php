<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lot extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
        'cadastral_number',
        'images',
        'start_price',
        'auction_step',
        'is_step_rub',
        'deposit',
        'is_deposit_rub',
        'description',
        'status_id',
        'price_state',
        'auction_id',
        'price_reduction',
        'concours',
        'participants',
        'payment_info',
        'sale_agreement',
        'is_parse_ecp'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'images' => 'array',
        'price' => 'integer',
        'auction_id' => 'integer',
        'auction_step' => 'integer',
        'deposit' => 'integer',
        'is_parse_ecp' => 'boolean',
        'is_auction_step_rub' => 'boolean',
        'is_deposit_rub' => 'boolean',
        'price_reduction' => 'array',
        'status_id' => 'integer',
    ];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    public function favourites()
    {
        return $this->hasMany(Favourite::class);
    }

    public function monitorings()
    {
        return $this->hasMany(Monitoring::class);
    }

    public function marks()
    {
        return $this->belongsToMany(Mark::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'lot_categories');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function fixedLots()
    {
        return $this->belongsToMany(User::class,'fixed_lots');
    }

    public function seenLots()
    {
        return $this->belongsToMany(User::class,'seen_lots');
    }

    public function hiddenLots()
    {
        return $this->belongsToMany(User::class,'hidden_lots');
    }


    public function lotParams()
    {
        return $this->hasMany(LotParam::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function tradeMessages()
    {
        return $this->hasMany(TradeMessage::class);
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'item');
    }

    public function lotFiles()
    {
        return $this->hasMany(LotFile::class);
    }
}
