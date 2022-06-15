<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'reminder_date',
        'item_id',
        'item_type',
        'user_id',
        'is_checked'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'item_id' => 'integer',
        'user_id' => 'integer',
        'reminder_date'=>'datetime',
        'is_checked'=>'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item(){

        return $this->morphTo();
    }
}
