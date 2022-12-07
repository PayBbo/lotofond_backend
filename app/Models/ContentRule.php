<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentRule extends Model
{
    use HasFactory;
    protected $table = 'content_rules';
    protected $fillable = ['title', 'code', 'is_available', 'type'];

    protected $casts = [
        'is_available'=>'boolean'
    ];
}
