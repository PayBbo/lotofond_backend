<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Application extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'lot_id',
        'email',
        'username',
        'phone',
        'for_answer',
        'answer_date',
        'topic',
        'question',
        'files',
        'cadastral_number',
        'status',
        'tariff_id',
        'payment_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'lot_id' => 'integer',
        'tariff_id'=> 'integer',
        'payment_id'=> 'integer',
        'answer_date' => 'timestamp',
        'is_answered'=>'boolean',
        'files'=>'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lot()
    {
        return $this->belongsTo(Lot::class);
    }

    public function tariff()
    {
        return $this->belongsTo(Tariff::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function getFiles()
    {
        $files = [];
        if(!is_null($this->files)) {
            foreach ($this->files as $file) {
                $files[] = URL::to('/').'/'.$file;
            }
        }
        return $files;
    }
}
