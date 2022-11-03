<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    use HasFactory;
    protected $table = 'tariffs';
    protected $fillable = [
        'title',
        'description',
        'period',
        'price',
        'store_id',
        'admission_price'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'period' => 'integer',
    ];

    public function payments()
    {
        return $this->hasMany(\App\Models\Payment::class);
    }
}
