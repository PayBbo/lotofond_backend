<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizerAnswerRating extends Model
{
    use HasFactory;

    protected $table = 'organizer_answer_ratings';

    protected $fillable = [
        'user_id',
        'answer_id',
        'comment',
        'estimate',
    ];
    protected $casts = [
        'user_id'=>'integer',
        'answer_id'=>'integer',
        'estimate'=>'integer'
    ];

    public function answer(){
        return $this->belongsTo(AdditionalLotInfo::class, 'answer_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
