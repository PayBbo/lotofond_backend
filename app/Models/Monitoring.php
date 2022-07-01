<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monitoring extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'color',
        'not_time',
        'unnecessary_words',
        'right_words',
        'filters'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'lot_id' => 'integer',
        'unnecessary_words' => 'array',
        'right_words' => 'array',
        'filters' => 'array'
    ];

    public function lots()
    {
        return $this->belongsToMany(Lot::class, 'lot_monitoring')->withPivot('created_at');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
