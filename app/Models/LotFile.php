<?php

namespace App\Models;

use App\Jobs\DeleteFileJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
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
          dispatch((new DeleteFileJob($file->type, $file->url))->onQueue('parse'));
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
