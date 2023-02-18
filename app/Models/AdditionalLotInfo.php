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
        'bidder_id',
        'lot_id'
    ];

    protected $casts = [
        'bidder_id' => 'integer',
        'lot_id' => 'integer',
        'is_moderated' => 'boolean'
    ];

    public function lot()
    {
        return $this->belongsTo(Lot::class);
    }

    public function bidder()
    {
        return $this->belongsTo(Bidder::class);
    }

    public function files()
    {
        return $this->hasMany(LotFile::class);
    }

}
