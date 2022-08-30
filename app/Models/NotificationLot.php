<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationLot extends Model
{
    use HasFactory;
    protected $table = 'notification_lot';
    protected $fillable = ['notification_id', 'lot_id'];
}
