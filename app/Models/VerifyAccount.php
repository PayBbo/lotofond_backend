<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifyAccount extends Model
{
    use HasFactory;
    protected $fillable = ['value', 'token', 'code', 'surname', 'name', 'phone', 'is_delete'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            logger($item);
          if(VerifyAccount::where(['value'=> $item->value, 'is_delete'=>$item->is_delete])->exists()){
              logger('yes');
              VerifyAccount::where(['value'=> $item->value, 'is_delete'=>$item->is_delete])->delete();
          }
          if(VerifyAccount::where(['phone'=> $item->phone, 'is_delete'=>$item->is_delete])->exists()){
              VerifyAccount::where(['phone'=> $item->phone, 'is_delete'=>$item->is_delete])->delete();
          }

        });

        static::updated(function ($category) {

        });

    }

}
