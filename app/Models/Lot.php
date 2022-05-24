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
        'address',
        'images',
        'price',
        'auction_step',
        'deposit',
        'description',
        'is_ecp',
        'title',
        'files',
        'category_id',
        'status_id',
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
        'auction_step' => 'integer',
        'deposit' => 'integer',
        'is_ecp' => 'boolean',
        'files' => 'array',
        'category_id' => 'integer',
        'status_id' => 'integer',
    ];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function auctions()
    {
        return $this->belongsToMany(Auction::class);
    }

    public function monitorings()
    {
        return $this->belongsToMany(Monitoring::class);
    }

    public function favourites()
    {
        return $this->belongsToMany(Favourite::class);
    }

    public function marks()
    {
        return $this->belongsToMany(Mark::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
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

    public function lotParams()
    {
        return $this->hasMany(LotParam::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
