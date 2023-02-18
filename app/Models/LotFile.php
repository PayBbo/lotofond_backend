<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class LotFile extends Model
{
    use HasFactory;

    protected $table = 'lot_files';

    protected $fillable = [
        'url',
        'type',
        'user_id',
        'lot_id',
        'trade_message_id',
        'additional_lot_info_id'
    ];

    protected $casts = [
        'user_id' => 'integer',
        'lot_id' => 'integer',
        'trade_message_id' => 'integer',
        'additional_lot_info_id'=> 'integer',
    ];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($file) {
            if($file->type == 'file'){
                Storage::disk('public')->delete(substr($file->url, strpos($file->url, 'storage/') +8));
            }else{
                Storage::disk('public')->delete(substr($file->url[0],  strpos($file->url[0], 'storage/') +8));
                Storage::disk('public')->delete(substr($file->url[1],  strpos($file->url[1], 'storage/') +8));
            }
        });

    }

    public function lot()
    {
        return $this->belongsTo(Lot::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tradeMessage()
    {
        return $this->belongsTo(TradeMessage::class);
    }

    public function getUrlAttribute($value) {
        $urls = json_decode( $value, true);
        if(gettype($urls) == 'array'){
            $result = [];
            foreach($urls as $url){
                $result[] =  URL::to('/').'/'.$url;
            }
            return $result;
        }else{
            $val = json_decode($value);
            if($val) {
                return URL::to('/') . '/' . $val;
            }else{
                return URL::to('/') . '/' . $value;
            }
        }
    }
}
