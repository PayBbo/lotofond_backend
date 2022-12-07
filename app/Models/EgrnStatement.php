<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EgrnStatement extends Model
{
    use HasFactory;

    protected $table = 'egrn_statements';
    protected $fillable = ['order_id', 'file', 'application_id', 'status', 'last_check_date'];

    protected $casts = [
        'last_check_date' => 'datetime'
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
