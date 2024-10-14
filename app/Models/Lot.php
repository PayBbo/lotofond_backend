<?php

namespace App\Models;

use App\Http\Resources\FavouritePathResource;
use App\Jobs\SendApplication;
use App\Utilities\FilterBuilder;
use App\Utilities\SortBuilder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Lot extends Model
{
    use HasFactory;

    protected $table = 'lots';

    protected $appends = ['photos', 'description_extracts'];
    protected $with = ['prevPrice', 'currentPriceReduction'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'start_price',
        'min_price',
        'auction_step',
        'is_step_rub',
        'deposit',
        'is_deposit_rub',
        'description',
        'processed_description',
        'status_id',
        'auction_id',
        /*'participants',
        'payment_info',
        'sale_agreement',
        'concours',*/
        'created_at',
        'price_reduction',
        'guid',
        'active',
        'number'

    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'start_price' => 'float',
        'min_price' => 'float',
        'auction_id' => 'integer',
        'auction_step' => 'float',
        'deposit' => 'float',
        'is_auction_step_rub' => 'boolean',
        'is_deposit_rub' => 'boolean',
        'status_id' => 'integer',
        'active' => 'boolean'
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

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function fixedLots()
    {
        return $this->belongsToMany(User::class, 'fixed_lots')->withPivot('created_at');
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

    public function paramsLot()
    {
        return $this->hasMany(LotParam::class);
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
        return $this->hasMany(LotFile::class)->where('type', 'image')->orWhere('type', 'video');
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
        return $this->hasMany(PriceReduction::class)->where('is_system', '=', false)
            ->select(['id', 'start_time as time', 'price', 'lot_id']);
    }


    public function currentPriceReduction()
    {
        $currentDate = Carbon::now()->setTimezone('Europe/Moscow');

        return $this->hasOne(PriceReduction::class)
            ->where('start_time', '<', $currentDate)
            ->where(function ($query) {
                $query->where('end_time', '>=', Carbon::now()->setTimezone('Europe/Moscow'))
                    ->orWhereNull('end_time');
            })
            ->latest('start_time')
            ->latest('end_time');
    }

    public function currentPriceReductionForFilter()
    {
        $currentDate = Carbon::now()->setTimezone('Europe/Moscow');

        return $this->hasOne(PriceReduction::class)
            ->where('start_time', '<', $currentDate)
            ->where(function ($query) use ($currentDate) {
                $query->where('end_time', '>=', $currentDate)
                    ->orWhereNull('end_time');
            })
            ->where(function ($query) use ($currentDate) {
                $query->where('start_time', function ($q) use ($currentDate) {
                    $q->selectRaw('max(start_time)')
                        ->from('price_reductions')
                        ->whereColumn('price_reductions.lot_id', 'lots.id')
                        ->where('start_time', '<', $currentDate)
                        ->where(function ($q2) use ($currentDate) {
                            $q2->where('end_time', '>=', $currentDate)
                                ->orWhereNull('end_time');
                        });
                });
            })
            ->latest('end_time')
            ->latest('id');
    }

    public function prevPrice()
    {
        $currentDate = Carbon::now()->setTimezone('Europe/Moscow');

        return $this->hasOne(PriceReduction::class)
            ->where('start_time', '<', $currentDate)
            ->where(function ($query) use ($currentDate) {
                $query->where('end_time', '<', $currentDate)
                    ->orWhereNull('end_time');
            })
            ->orderBy('end_time');

    }


    public function getPhotosAttribute()
    {
        return $this->lotImages
            ->filter(function ($image) {
                return $image->user_id === null || $image->user_id === auth()->guard('api')->id();
            })
            ->map(function ($image) {
                return [
                    'type' => $image->user_id === null ? 'system' : 'user',
                    'main' => $image->url[0],
                    'preview' => $image->url[1],
                    'id' => $image->id
                ];
            })
            ->toArray();
    }

    public function userMarks()
    {
        return $this->belongsToMany(Mark::class)->where('user_id', auth()->id())->select('id', 'title');
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

            return $sort->apply();
        }
        return $query->isFixed();

    }

    public function scopeFilterBy($query, $request)
    {
        $namespace = 'App\Utilities\LotFilters';
        $filters = new FilterBuilder($query, $request, $namespace);
        return $filters->apply();

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
        if (auth()->guard('api')->check()) {
            $existsNote = Note::where(['user_id' => auth()->guard('api')->id(),
                'item_type' => 'lot', 'item_id' => $this->id])->first();
            if ($existsNote) {
                $note = $existsNote->only('id', 'title', 'date');
            }
        }
        return $note;
    }

    public function getLotFavouritePaths()
    {
        if (!auth()->guard('api')->check()) {
            return null;
        }
        return FavouritePathResource::collection( auth()->guard('api')->user()
            ->favourites()
            ->withCount('lots')
            ->hasByNonDependentSubquery('lots', function ($query) {
                $query->where('lot_id', $this->id);
            })
            ->get());
    }

    public function lotParams()
    {
        return $this->hasMany(LotParam::class)->where('parent_id', null)->orderBy('created_at', 'desc')->with(['param', 'childParams']);
    }

    public function getDescriptionExtractsAttribute()
    {
         $result = [];
         $admin = Auth::user()->hasRole('admin');
          foreach ($this->lotParams->unique('value') as $param) {
              $extracts = [];
              foreach ($param->childParams as $sub) {
                  $subArray = [
                      'title' => $sub->param->title,
                      'type' => $sub->param->type,
                      'value' => $sub->value
                  ];
                  if($admin) {
                      $subArray['id'] = $sub->id;
//                      $subArray['parent_id'] = $sub->parent_id;
                  }
                  $extracts[] = $subArray;
              }
              $tradeSubject = $param->value;
              $type = is_null($param->type) ? 'other' : $param->type;
              if (count($extracts) == 0) {
                  $paramArray = [
                      'title' => $param->param->title,
                      'type' => $param->param->type,
                      'value' => $param->value
                  ];
                  if ($admin) {
                      $paramArray['id'] = $param->id;
                  }
                  $extracts[] = $paramArray;
                  $tradeSubject = null;
                  $type = 'other';
              }
              $result[] = compact('tradeSubject', 'type', 'extracts');
          }
        return $result;
    }

    public function getCoordinatesAttribute()
    {
        $result = [];
        $params = $this->lotParams->where('param_id', 11)->unique('value');
        foreach ($params as $param) {
            $result[] = ['coordinates' => explode(" ", $param->value)];
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

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'lot_categories')->with(['parentRelated', 'subcategories']);
    }

    public function categoriesStructure()
    {
        $categories = [];
        $parents = $this->categories->map(function ($category) {
            return !is_null($category->parent_id) ? $category->parentRelated : $category;
        });
        $categoriesIds = $this->categories->pluck('id')->unique()->toArray();
        foreach ($parents->unique('label') as $parent) {
            $subs = $parent->subcategories->whereIn('id', $categoriesIds);
            $subcategories = $subs->unique('label')->map(function ($sub) {
                return ['label' => $sub->label, 'key' => $sub->title];
            })->all();
            $categories[] = ['label' => $parent->label, 'key' => $parent->title, 'subcategories' => $subcategories];
        }
        return $categories;
    }

    public function getDescriptionAttribute($value)
    {
        return preg_replace("/&#?[a-z0-9]{2,8};/i", "", $value);
    }

    public function getProcessedDescriptionAttribute($value)
    {
        return preg_replace("/&#?[a-z0-9]{2,8};/i", "", $value);
    }

    public function getStartPriceAttribute($value)
    {
        return $value == 0 ? null : (float)$value;
    }

    public function getMinPriceAttribute($value)
    {
        return $value == 0 ? null : (float)$value;
    }

    public function getAuctionStepAttribute($value)
    {
        return $value == 0 ? null : (float)$value;
    }

    public function getDepositAttribute($value)
    {
        return $value == 0 ? null : (float)$value;
    }

    public function notificationLots()
    {
        return $this->belongsToMany(Notification::class, 'notification_lot');
    }

    public function showRegions()
    {
        return $this->belongsToMany(Region::class, 'lot_regions')->withPivot('is_debtor_region')->select('code', 'lot_regions.is_debtor_region as isDebtorRegion')->distinct()->orderBy('is_debtor_region');
    }

    public function favouritePaths()
    {
        return $this->belongsToMany(Favourite::class)->where('user_id', auth()->guard('api')->id());
    }

    public function monitoringPaths()
    {
        return $this->belongsToMany(Monitoring::class, 'lot_monitoring')->where('user_id', auth()->guard('api')->id());
    }

    public function userApplications()
    {
        return $this->hasMany(Application::class)->where('user_id', auth()->id());
    }


    public function additionalLotInfo()
    {
        return $this->hasOne(AdditionalLotInfo::class);
    }
}
