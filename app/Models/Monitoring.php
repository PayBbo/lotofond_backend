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
        'not_frequency',
        'unnecessary_words',
        'right_words',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'unnecessary_words' => 'array',
        'right_words' => 'array',
    ];

    public function lots()
    {
        return $this->belongsToMany(Lot::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
