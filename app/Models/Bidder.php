<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidder extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'inn',
        'ogrn',
        'snils',
        'address',
        'reg_number',
        'cpo',
        'region_id',
        'bidder_type_id',
        'bidder_category_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'region_id' => 'integer',
        'bidder_type_id' => 'integer',
        'bidder_category_id' => 'integer',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function bidderType()
    {
        return $this->belongsTo(BidderType::class);
    }

    public function bidderCategory()
    {
        return $this->belongsTo(BidderCategory::class);
    }

    public function auctions()
    {
        return $this->hasMany(Auction::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function registryNotifications()
    {
        return $this->hasMany(RegistryNotification::class);
    }
}
