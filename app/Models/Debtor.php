<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debtor extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'short_name',
        'inn',
        'ogrn',
        'ogrnip',
        'snils',
        'address',
        'region_id',
        'debtor_category_id',
        'bankrupt_id',
        'date_of_last_modifier'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'region_id' => 'integer',
        'debtor_category_id' => 'integer',
        'date_of_last_modifier' => 'datetime'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function debtorCategory()
    {
        return $this->belongsTo(DebtorCategory::class);
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
