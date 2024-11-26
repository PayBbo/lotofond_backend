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
        'parent_id',
        'type'
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
        'parent_id' => 'integer',
        'coordinates' => 'array',
    ];

    public function childParams(){
        return $this->hasMany('app\Models\LotParam', 'parent_id', 'id')->with('param');
    }

    public function param(){
        return $this->belongsTo(Param::class);
    }

}
