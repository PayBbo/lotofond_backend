<?php

namespace App\Models;

use App\Http\Resources\FavouritePathResource;
use App\Utilities\FilterBuilder;
use App\Utilities\SortBuilder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lot extends Model
{
    use HasFactory;

    protected $table = 'lots';

    protected $appends = ['min_price', 'photos', 'description_extracts'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'start_price',
        'auction_step',
        'is_step_rub',
        'deposit',
        'is_deposit_rub',
        'description',
        'status_id',
        'auction_id',
        'participants',
        'payment_info',
        'sale_agreement',
        'concours',
        'created_at'

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'start_price' => 'float',
        'auction_id' => 'integer',
        'auction_step' => 'float',
        'deposit' => 'float',
        'is_parse_ecp' => 'boolean',
        'is_auction_step_rub' => 'boolean',
        'is_deposit_rub' => 'boolean',
        'status_id' => 'integer'
    ];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    public function favourites()
    {
        return $this->hasMany(Favourite::class);
    }

    public function monitorings()
    {
        return $this->belongsToMany(Monitoring::class, 'lot_monitoring')->withPivot('created_at', 'has_notification');
    }

    public function marks()
    {
        return $this->belongsToMany(Mark::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'lot_categories')->with(['parentRelated']);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function fixedLots()
    {
        return $this->belongsToMany(User::class, 'fixed_lots');
    }

    public function seenLots()
    {
        return $this->belongsToMany(User::class, 'seen_lots');
    }

    public function hiddenLots()
    {
        return $this->belongsToMany(User::class, 'hidden_lots');
    }


    public function params()
    {
        return $this->belongsToMany(Param::class, 'lot_params')->withPivot('value', 'parent_id');
    }

    public function regions()
    {
        return $this->belongsToMany(Region::class, 'lot_regions')->withPivot('is_debtor_region');
    }

    public function objectRegions()
    {
        return $this->belongsToMany(Region::class, 'lot_regions')->withPivot('is_debtor_region')
            ->wherePivot('is_debtor_region', '=', false);

    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function tradeMessages()
    {
        return $this->hasMany(TradeMessage::class);
    }

    public function lotFiles()
    {
        return $this->hasMany(LotFile::class)->where('user_id', null);
    }


    public function userLotFiles()
    {
        return $this->hasMany(LotFile::class)->where('user_id', auth()->id());
    }

    public function lotImages()
    {
        return $this->hasMany(LotFile::class)->where('type', 'image');
    }

    public function lotUserImages()
    {
        return $this->hasMany(LotFile::class)->where(['type' => 'image', 'user_id' => auth()->id()]);
    }

    public function priceReductions()
    {
        return $this->hasMany(PriceReduction::class);
    }

    public function showPriceReductions()
    {
        return $this->hasMany(PriceReduction::class)->where('is_system', false)->select('id', 'start_time as time', 'price');
    }

    public function priceReductionMin()
    {
        $lots = PriceReduction::groupBy('lot_id')->pluck('lot_id')->toArray();
        $prices = [];
        foreach ($lots as $lot) {
            $price = PriceReduction::where('lot_id', $lot)->min('price');
            $prices[] = PriceReduction::where(['lot_id' => $lot, 'price' => $price])->first()['id'];
        }
        return $this->hasMany(PriceReduction::class)->whereIn('id', $prices);
    }

    public function currentPriceReduction()
    {
        $currentDate = Carbon::now()->setTimezone('Europe/Moscow');

        return $this->hasOne(PriceReduction::class)
            ->whereDate('start_time', '<', $currentDate)
            ->where(function ($query) use ($currentDate) {
                $query->whereDate('end_time', '>=', $currentDate)
                    ->orWhere('end_time', '=', null);
            })
            ->orderBy('end_time', 'desc');
    }

    public function getMinPriceAttribute()
    {
        $prices = $this->hasMany(PriceReduction::class)->pluck('price')->toArray();
        $prices[] = $this->start_price;
        return min($prices);

    }

    public function getPhotosAttribute()
    {
        $photos = [];
        foreach ($this->lotImages->where('user_id', null) as $image) {
            $photos[] = ['type' => 'system', 'main' => $image->url[0], 'preview' => $image->url[1], 'id' => $image->id];
        }
        if (auth()->check()) {
            foreach ($this->lotImages->where('user_id', auth()->guard('api')->id()) as $image) {
                $photos[] = ['type' => 'user', 'main' => $image->url[0], 'preview' => $image->url[1], 'id' => $image->id];
            }
        }
        return $photos;
    }

    public function userMarks()
    {
        return $this->belongsToMany(Mark::class)->where('user_id', auth()->id())->select('id', 'title')->get();
    }

    public function userMarksForSearch()
    {
        return $this->belongsToMany(Mark::class)->where('user_id', auth()->id());
    }

    public function scopeCustomSortBy($query, $request)
    {
        if (isset($request->sort) && isset($request->sort['direction']) && strlen((string)$request->sort['direction']) > 0
            && isset($request->sort['type']) && strlen((string)$request->sort['type']) > 0) {
            $namespace = 'App\Utilities\LotSorts';
            $sort = new SortBuilder($query->isFixed(), $request->sort, $namespace);

            return $sort->apply()->groupBy('lots.id');
        }
        return $query->isFixed()->groupBy('lots.id');

    }

    public function scopeFilterBy($query, $request)
    {
        $namespace = 'App\Utilities\LotFilters';
        $filters = new FilterBuilder($query, $request, $namespace);
        return $filters->apply()->groupBy('lots.id');

    }

    public function inFavourite()
    {
        return auth()->guard('api')->user()->favourites()->whereHas('lots', function ($query) {
                $query->where('lot_id', $this->id);
            })->count() > 0;


    }

    public function inMonitoring()
    {
        return auth()->guard('api')->user()->monitorings()->whereHas('lots', function ($query) {
                $query->where('lot_id', $this->id);
            })->count() > 0;

    }

    public function getNote()
    {
        $note = null;
        if (auth()->guard('api')->check() && Note::where(['user_id' => auth()->guard('api')->id(),
                'item_type' => 'lot', 'item_id' => $this->id])->exists()) {
            $note = Note::where(['user_id' => auth()->guard('api')->id(),
                'item_type' => 'lot', 'item_id' => $this->id])->first()->only('id', 'title', 'date');
        }
        return $note;
    }

    public function getLotFavouritePaths()
    {
        if (auth()->guard('api')->check()) {
            $user = auth()->guard('api')->user();
            return FavouritePathResource::collection($user->favourites()->whereHas('lots', function ($query) {
                $query->where('lot_id', $this->id);
            })->get());
        }
        return null;
    }

    public function lotParams()
    {
        return $this->hasMany(LotParam::class)->where('parent_id', null)->with(['param', 'childParams']);
    }

    public function getDescriptionExtractsAttribute()
    {
        $result = [];
        $params = $this->lotParams;
        foreach ($params as $param) {
            $extracts = [];
            foreach ($param->childParams as $sub) {
                $extracts[] = [
                    'title' => $sub->param->title,
                    'type' => $sub->param->type,
                    'value' => $sub->value
                ];
            }
            if (count($extracts) > 0) {
                $result[] = [
                    'tradeSubject' => $param->value,
                    'type' => is_null($param->type) ? 'other' : $param->type,
                    'extracts' => $extracts
                ];

            } else {
                $extracts[] = [
                    'title' => $param->param->title,
                    'type' => $param->param->type,
                    'value' => $param->value
                ];
                $result[] = [
                    'tradeSubject' => null,
                    'type' => 'other',
                    'extracts' => $extracts
                ];
            }
        }

        return $result;
    }

    public function userHiddenLot()
    {
        return $this->belongsToMany(User::class, 'hidden_lots')->where('user_id', auth()->guard('api')->id());
    }

    public function scopeIsFixed($query)
    {
        if (auth()->guard('api')->check()) {
            $query->orderBy(FixedLot::select('created_at')
                ->whereColumn('lots.id', 'fixed_lots.lot_id')
                ->where('fixed_lots.user_id', auth()->guard('api')->id())
                ->take(1),
                'desc'
            );

        }
    }

    public function categoriesStructure()
    {
        $categories = [];
        $parents = [];
        foreach ($this->categories as $category) {
            if (!is_null($category->parent_id)) {
                $parents[] = $category->parentRelated;
            } else {
                $parents[] = $category;
            }
        }
        $categoriesIds = $this->categories->pluck('id')->toArray();
        $serialized = array_map('serialize', $parents);
        $unique = array_unique($serialized);
        $parents = array_intersect_key($parents, $unique);
        foreach ($parents as $category) {
            $subs = $category->subcategories()->whereIn('id', array_unique($categoriesIds))->get();
            $subcategories = [];
            foreach ($subs as $sub) {
                $value = ['label' => $sub->label, 'key' => $sub->title];
                if (!in_array($value, $subcategories)) {
                    $subcategories[] = $value;
                }
            }
            $categories[] = ['label' => $category->label, 'key' => $category->title, 'subcategories' => $subcategories];
        }
        return $categories;

    }

    public function hasNotSeenNotification()
    {
        $favourites = auth()->guard('api')->user()->favourites()->whereHas('lots', function ($query) {
            $query->where('lots.id', $this->id);
        })->get();
        foreach ($favourites as $favourite) {
            $ids = $favourite->lots()->where('lots.id', $this->id)->pluck('favourite_lot.id')->toArray();
            if (Notification::whereIn('lot_id', $ids)->where(['user_id' => auth()->guard('api')->id(), 'is_seen' => false])->exists()) {
                return true;
            }
        }
        return false;
    }

    public function getDescriptionAttribute($value)
    {
        $result = htmlentities($value);
        $result = preg_replace('/^(&quot;)(.*)(&quot;)$/', "$2", $value);
        $result = preg_replace('/^(&laquo;)(.*)(&raquo;)$/', "$2", $result);
        $result = preg_replace('/^(&#8220;)(.*)(&#8221;)$/', "$2", $result);
        $result = preg_replace('/^(&#39;)(.*)(&#39;)$/', "$2", $result);
        return stripslashes(html_entity_decode($result));
    }

    public function notificationLots()
    {
        return $this->belongsToMany(Notification::class, 'notification_lot');
    }

    public function showRegions()
    {
        return $this->belongsToMany(Region::class, 'lot_regions')->withPivot('is_debtor_region')->select('code', 'lot_regions.is_debtor_region as isDebtorRegion');
    }

    public function favouritePaths()
    {
        return $this->belongsToMany(Favourite::class)->where('user_id', auth()->guard('api')->id());
    }

    public function monitoringPaths()
    {
        return $this->belongsToMany(Monitoring::class, 'lot_monitoring')->where('user_id', auth()->guard('api')->id());
    }

}
