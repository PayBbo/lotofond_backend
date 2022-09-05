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

    protected $appends = ['current_price', 'min_price', 'current_price_state', 'photos', 'description_extracts'];
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
        return $this->belongsToMany(Category::class, 'lot_categories');
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
        return $this->hasMany(LotFile::class)->where('user_id',null);
    }


    public function userLotFiles()
    {
        return $this->hasMany(LotFile::class)->where('user_id', auth()->id());
    }

    public function lotImages()
    {
        return $this->hasMany(LotFile::class)->where(['type' => 'image', 'user_id' => null]);
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
        return $this->hasMany(PriceReduction::class)->where('is_system', false);
    }

    public function priceReductionMin()
    {
        $lots = PriceReduction::groupBy('lot_id')->pluck('lot_id')->toArray();
        $prices = [];
        foreach($lots as $lot){
            $price = PriceReduction::where('lot_id', $lot)->min('price');
            $prices[] = PriceReduction::where(['lot_id'=>$lot, 'price'=>$price])->first()['id'];
        }
        return $this->hasMany(PriceReduction::class)->whereIn('id', $prices);
    }

    public function currentPriceReduction()
    {
        $currentDate = Carbon::now()->setTimezone('Europe/Moscow');
        return $this->hasMany(PriceReduction::class)
            ->whereDate('start_time', '<=', $currentDate)
            ->where(function ($query) use ($currentDate) {
                $query->whereDate('end_time', '>', $currentDate)
                    ->orWhere('end_time', '=', null);
            })
            ->take(1);
    }

    public function getCurrentPriceAttribute()
    {
        if ($this->has('priceReductions')) {
            $currentRed = $this->currentPriceReduction()->first();
            if ($currentRed) {
                return $currentRed->price;
            } else {
                return $this->start_price;
            }
        } else {
            return $this->start_price;
        }
    }

    public function getMinPriceAttribute()
    {
        $prices = $this->hasMany(PriceReduction::class)->pluck('price')->toArray();
        $prices[] = $this->start_price;
        return min($prices);

    }

    public function getCurrentPriceStateAttribute()
    {
        if ($this->has('priceReductions')) {
            $currentPrice = $this->currentPriceReduction()->first();
            if ($currentPrice) {
                $prev = PriceReduction::where('id', '<', $currentPrice->id)
                    ->latest('id')
                    ->first();
                if ($prev && $prev->lot_id == $this->id) {
                    if ((float)$prev->price > (float)$currentPrice->price) {
                        return 'down';
                    } elseif ((float)$prev->price < (float)$currentPrice->price) {
                        return 'up';
                    } else {
                        return 'hold';
                    }
                } else {
                    if ((float)$this->start_price > (float)$currentPrice->price) {
                        return 'down';
                    } elseif ((float)$this->start_price < (float)$currentPrice->price) {
                        return 'up';
                    } else {
                        return 'hold';
                    }
                }
            } else {
                return 'hold';
            }
        } else {
            return 'hold';
        }
    }

    public function getPhotosAttribute()
    {
        $photos = [];
        foreach ($this->lotImages as $image) {
            $photos[] = ['type' => 'system', 'main' => $image->url[0], 'preview' => $image->url[1], 'id' => $image->id];
        }
        if (auth()->check()) {
            foreach ($this->lotUserImages as $image) {
                $photos[] = ['type' => 'user', 'main' => $image->url[0], 'preview' => $image->url[1],  'id' => $image->id];
            }
        }
        return $photos;
    }

    public function userMarks(){
        return $this->belongsToMany(Mark::class)->where('user_id', auth()->id())->select('id', 'title')->get();
    }

    public function userMarksForSearch(){
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

    public function inFavourite(){
        $favourites = auth()->guard('api')->user()->favourites;
        foreach($favourites as $favourite){
            if($favourite->lots()->where('lots.id', $this->id)->exists()){
                return true;
            }
        }
        return false;

    }

    public function inMonitoring(){
        $monitorings = auth()->guard('api')->user()->monitorings;
        foreach($monitorings as $monitoring){
            if($monitoring->lots()->where('lots.id', $this->id)->exists()){
                return true;
            }
        }
        return false;

    }

    public function getNote(){
        $note = null;
        if(auth()->guard('api')->check() && Note::where(['user_id'=>auth()->guard('api')->id(),
                'item_type'=>'lot', 'item_id'=>$this->id])->exists() ){
            $note = Note::where(['user_id'=>auth()->guard('api')->id(),
                'item_type'=>'lot', 'item_id'=>$this->id])->first()->only('id', 'title', 'date');
        }
        return $note;
    }

    public function getLotFavouritePaths(){
        if(auth()->guard('api')->check()) {
            $user = auth()->guard('api')->user();
                return FavouritePathResource::collection($user->favourites()->whereHas('lots', function ($query) {
                    $query->where('lot_id', $this->id);
                })->get());
        }
        return null;
    }

    public function getDescriptionExtractsAttribute(){
        $result = [];
        $params = $this->params()->where('lot_params.parent_id', null)
            ->select('lot_params.id as lot_param_id','title', 'params.type as type', 'lot_params.type as param_type', 'lot_params.value as value')->get();
        foreach($params as $param){
            $subParams = $this->params()->where('lot_params.parent_id', $param->lot_param_id)->select('title', 'params.type as type', 'lot_params.type as param_type', 'lot_params.value as value')->get();
            if($subParams->count()>0){
                $result[] = [
                    'tradeSubject'=>$param->value,
                    'type'=> is_null($param->param_type) ? 'other' : $param->param_type,
                    'extracts'=>$subParams->makeHidden(['pivot', 'param_type'])
                ];

            }else{
                $result[] = [
                    'tradeSubject'=>null,
                    'type'=>'other',
                    'extracts'=>[$param->makeHidden(['pivot', 'lot_param_id', 'param_type'])]
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
        if(auth()->guard('api')->check()) {
             $query->orderBy(FixedLot::select('created_at')
                ->whereColumn('lots.id', 'fixed_lots.lot_id')
                ->where('fixed_lots.user_id', auth()->guard('api')->id())
                ->take(1),
                'desc'
            );

        }
    }
    public function categoriesStructure(){
        $categories = [];
        $parents = [];
        foreach ($this->categories as $category) {
            if (!is_null($category->parent())) {
                $parents[] = $category->parent();
            } else {
                $parents[] = $category;
            }
        }
        $categoriesIds = $this->categories->pluck('id')->toArray();
        $serialized = array_map('serialize', $parents);
        $unique = array_unique($serialized);
        $parents = array_intersect_key($parents, $unique);
        foreach ($parents as $category) {
            $subs = array_intersect($category->subcategories()->pluck('id')->toArray(), $categoriesIds);
            $subs = Category::whereIn('id', array_unique($subs))->get();
            $subcategories = [];
            foreach($subs as $sub){
                $value = ['label'=>$sub->label, 'key'=>$sub->title];
                if(!in_array($value, $subcategories)) {
                    $subcategories[] = $value;
                }
            }
            $categories[] = ['label'=>$category->label, 'key'=>$category->title, 'subcategories'=>$subcategories];
        }
        return $categories;
    }

    public function hasNotSeenNotification(){
        $favourites = auth()->guard('api')->user()->favourites;
        foreach($favourites as $favourite){
            if($favourite->lots()->where('lots.id', $this->id)->exists()){
                $ids = $favourite->lots()->pluck('favourite_lot.id')->toArray();
                if(Notification::whereIn('lot_id', $ids)->where(['user_id'=> auth()->guard('api')->id(), 'is_seen'=>false])->exists()){
                    return true;
                }
            }
        }
        return false;
    }

    public function getDescriptionAttribute($value){
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
}
