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
            if(ChangeCredentials::where(['email'=> $item->email, 'user_id'=>$item->user_id, 'is_old_credentials'=>$item->is_old_credentials])->exists()){
                ChangeCredentials::where(['email'=> $item->email, 'user_id'=>$item->user_id, 'is_old_credentials'=>$item->is_old_credentials])->delete();
            }else if(ChangeCredentials::where(['phone'=> $item->phone, 'user_id'=>$item->user_id, 'is_old_credentials'=>$item->is_old_credentials])->exists()){
                ChangeCredentials::where(['phone'=> $item->phone, 'user_id'=>$item->user_id, 'is_old_credentials'=>$item->is_old_credentials])->delete();
            }

        });

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
