<?php

namespace App\Models;

use Carbon\Carbon;
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
        'start_price',
        'auction_step',
        'is_step_rub',
        'deposit',
        'is_deposit_rub',
        'description',
        'status_id',
        'price_state',
        'auction_id',
        'concours',
        'participants',
        'payment_info',
        'sale_agreement',
        'is_parse_ecp',
        'price_reduction'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'images' => 'array',
        'start_price' => 'decimal:2',
        'auction_id' => 'integer',
        'auction_step' =>'decimal:2',
        'deposit' => 'decimal:2',
        'is_parse_ecp' => 'boolean',
        'is_auction_step_rub' => 'boolean',
        'is_deposit_rub' => 'boolean',
        'status_id' => 'integer',
        'price_reduction' => 'array'
    ];

    protected $appends = ['current_price', 'current_price_state'];

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

    public function getCurrentPriceAttribute(){
        if(is_null($this->price_reduction) || count($this->price_reduction) == 0){
            return $this->start_price;
        }else{
            $date = Carbon::now();
            for($i=0; $i<= count($this->price_reduction)-1; $i++){
                $date1 = Carbon::parse($this->price_reduction[$i]['time']);
                if($i+1 <= count($this->price_reduction)-1) {
                    $date2 = Carbon::parse($this->price_reduction[$i+1]['time']);
                    if ($date1 < $date && $date2 > $date) {
                        return $this->price_reduction[$i]['price'];
                    }
                }else {
                    if ($date1 < $date) {
                        return $this->price_reduction[$i]['price'];
                    }else{
                        return $this->start_price;
                    }
                }
            }

        }
    }

    public function getCurrentPriceStateAttribute(){
        if(is_null($this->price_reduction) || count($this->price_reduction) == 0){
            return 'hold';
        }else{
            $date = Carbon::now();
            for($i=0; $i< count($this->price_reduction)-1; $i++){
                if($i+1 < count($this->price_reduction)-1) {
                    $date1 = Carbon::parse($this->price_reduction[$i]['time']);
                    $date2 = Carbon::parse($this->price_reduction[$i+1]['time']);
                    if ($date1 < $date && $date2 > $date) {
                        if($i-1 >= 0) {
                            if ($this->price_reduction[$i]['price'] > $this->price_reduction[$i - 1]['price']) {
                                return 'up';
                            } elseif ($this->price_reduction[$i]['price'] < $this->price_reduction[$i - 1]['price']) {
                                return 'down';
                            } else {
                                return 'hold';
                            }
                        }else{
                            if ($this->price_reduction[$i]['price'] > $this->start_price) {
                                return 'up';
                            } elseif ($this->price_reduction[$i]['price'] < $this->start_price) {
                                return 'down';
                            } else {
                                return 'hold';
                            }
                        }
                    }
                }else{
                    return 'hold';
                }
            }
        }
    }
}
