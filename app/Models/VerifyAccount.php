<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifyAccount extends Model
{
    use HasFactory;
    protected $fillable = ['value', 'token', 'code', 'surname', 'name', 'phone'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
          if(VerifyAccount::where('value', $item->value)->exists()){
              VerifyAccount::where('value', $item->value)->delete();
          }
        });

        static::updated(function ($category) {

        });

    }

}
