<?php

namespace App\Models;

use App\Utilities\FilterBuilder;
use App\Utilities\SortBuilder;
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
        'message_id',
        'files',
        'debtor_id',
        'type_id',
        'publish_date',
        'guid'
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
        'publish_date'=>'datetime'
    ];

    public function debtor()
    {
        return $this->belongsTo(Bidder::class, 'debtor_id');
    }

    public function registryNotificationType()
    {
        return $this->belongsTo(RegistryNotificationType::class, 'type_id');
    }

    public function scopeCustomSortBy($query, $request)
    {
        if (isset($request->sort) && isset($request->sort['direction']) && strlen((string)$request->sort['direction']) > 0
            && isset($request->sort['type']) && strlen((string)$request->sort['type']) > 0) {
            $namespace = 'App\Utilities\RegistryNotificationsSort';
            $sort = new SortBuilder($query, $request->sort, $namespace);

            return $sort->apply();
        }
        return $query;
    }

    public function scopeFilterBy($query, $request)
    {
        $namespace = 'App\Utilities\RegistryNotificationsFilters';
        $filters = new FilterBuilder($query, $request, $namespace);
        return $filters->apply();

    }
}
