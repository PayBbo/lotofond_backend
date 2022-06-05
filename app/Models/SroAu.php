<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SroAu extends Model
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
        'reg_num',
        'sro_id',
        'date_of_last_modifier',
        'phone'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'sro_id' => 'integer',
        'date_of_last_modifier' => 'datetime',
    ];

    public function arbitrManager()
    {
        return $this->belongsTo(ArbitrManager::class);
    }
}
