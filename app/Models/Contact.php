<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $table = 'contacts';
    protected $fillable = [
        'tariff_id',
        'type'
    ];

    public function tariff()
    {
        return $this->belongsTo(Tariff::class);
    }
}
