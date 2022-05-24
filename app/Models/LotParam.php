<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotParam extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'param_id',
        'lot_id',
        'value',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'param_id' => 'integer',
        'lot_id' => 'integer',
    ];

    public function param()
    {
        return $this->belongsTo(Param::class);
    }

    public function lot()
    {
        return $this->belongsTo(Lot::class);
    }
}
