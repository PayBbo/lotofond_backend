<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeCredentials extends Model
{
    use HasFactory;
    protected $table = 'change_credentials';
    protected $fillable = [
        'user_id',
        'email',
        'phone',
        'token',
        'is_old_credentials',
        'is_submitted_old_credentials'
    ];

    protected $casts = [
        'user_id'=>'integer',
        'is_old_credentials'=>'boolean',
        'is_submitted_old_credentials' => 'boolean'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            if(ChangeCredentials::where(['email'=> $item->value, 'user_id'=>$item->id])->exists()){
                ChangeCredentials::where(['email'=> $item->value, 'user_id'=>$item->id])->delete();
            }else if(ChangeCredentials::where(['phone'=> $item->phone, 'user_id'=>$item->id])->exists()){
                ChangeCredentials::where(['phone'=> $item->phone, 'user_id'=>$item->id])->delete();
            }

        });

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
