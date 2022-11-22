<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Tariff extends Model
{
    use HasFactory;
    use HasTranslations;

    public $translatable = ['title', 'description', 'included_details', 'excluded_details'];
    protected $table = 'tariffs';
    protected $fillable = [
        'title',
        'description',
        'period',
        'price',
        'store_id',
        'admission_price',
        'included_details',
        'excluded_details'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'period' => 'integer',
        'excluded_details'=>'array',
        'included_details'=>'array'
    ];

    public function payments()
    {
        return $this->hasMany(\App\Models\Payment::class);
    }
}
