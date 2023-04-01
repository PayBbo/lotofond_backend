<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $table = 'news';
    protected $fillable = ['description', 'image', 'is_banner'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($item) {

            if($item->is_banner){
                if(News::where('is_banner', true)->exists()) {
                    News::where('is_banner', true)->update(['is_banner'=> false]);
                }
            }

        });

        static::updating(function ($item) {

            if($item->is_banner){
                if(News::where('is_banner', true)->exists()) {
                    News::where('is_banner', true)->update(['is_banner'=> false]);
                }
            }

        });

    }
}
