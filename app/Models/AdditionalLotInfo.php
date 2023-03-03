<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalLotInfo extends Model
{
    use HasFactory;

    protected $table ='additional_lot_infos';

    protected $fillable = [
        'uid',
        'message',
        'is_moderated',
        'lot_id'
    ];

    protected $casts = [
        'lot_id' => 'integer',
        'is_moderated' => 'boolean'
    ];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($additional) {
            $additional->files->each(function ($file) { $file->delete(); });
        });

    }

    public function lot()
    {
        return $this->belongsTo(Lot::class);
    }

    public function files()
    {
        return $this->hasMany(LotFile::class);
    }

}
