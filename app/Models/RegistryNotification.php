<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistryNotification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'files',
        'debtor_id',
        'type_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'files' => 'array',
        'debtor_id' => 'integer',
        'type_id' => 'integer',
    ];

    public function debtor()
    {
        return $this->belongsTo(Bidder::class, 'debtor_id');
    }

    public function registryNotificationType()
    {
        return $this->belongsTo(RegistryNotificationType::class, 'type_id');
    }
}
