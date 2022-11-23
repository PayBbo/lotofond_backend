<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';
    protected $fillable = [
        'user_id',
        'payment_id',
        'sum',
        'tariff_id',
        'finished_at',
        'is_confirmed',
        'status'
    ];

    protected $casts = [
        'user_id'=>'integer',
        'sum'=>'float',
        'tariff_id' => 'integer',
        'finished_at' => 'timestamp',
        'is_confirmed'=>'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tariff()
    {
        return $this->belongsTo(\App\Models\Tariff::class);
    }
}
