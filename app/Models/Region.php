<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'code',
        'region_group_id',
        'numbers'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'region_group_id' => 'integer',
    ];

    public function regionGroup()
    {
        return $this->belongsTo(RegionGroup::class);
    }

    public function debtors()
    {
        return $this->hasMany(Bidder::class);
    }

    public function lots()
    {
        return $this->belongsToMany(Lot::class, 'lot_regions')->withPivot(['is_debtor_region']);
    }
}
