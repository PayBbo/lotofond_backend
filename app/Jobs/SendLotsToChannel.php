<?php

namespace App\Jobs;

use App\Http\Services\CacheService;
use App\Models\Lot;
use App\Models\Region;
use App\Models\User;
use App\Notifications\ApplicationTelegramNotification;
use Carbon\Carbon;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Telegram\Bot\Laravel\Facades\Telegram;

class SendLotsToChannel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $realtyCategories = [
            "land",
            "residentialProperty",
            "commercialRealEstate"
        ];
        $realtyType = 'countRealtyLotsChannel';
        $transportCategories = [
            "airTransport",
            "waterTransport",
            "freightTransport",
            "commercialTransport",
            "passengerTransport",
            "mototechnics"
        ];
        $transportType = 'countTransportLotsChannel';
        if (Cache::get($transportType) < 10) {
            $this->sendLots($transportCategories, $transportType);
        }
        $this->sendLots($realtyCategories, $realtyType);
        $this->sendLotsToClients();

    }

    public function sendLots($categories, $type)
    {
        $minDate = Carbon::now()->setTimezone('Europe/Moscow')->subHour();
        $maxDate = Carbon::now()->setTimezone('Europe/Moscow');
        $regions = Region::whereIn('region_group_id', [3, 7])->get()->pluck('code')->toArray();
        $regions[] = 'PenzaRegion';
        $this->query = Lot::whereBetween('lots.created_at', [$minDate, $maxDate])
            ->whereHas('categories', function ($query) use ($categories) {
                $query->whereIn('title', $categories);
            });
        $lots = $this->query->where(function ($query) use ($regions) {
            $query->whereHas('objectRegions', function ($q) use ($regions) {
                $q->whereIn('code', $regions);
            })->orWhereDoesntHave('objectRegions', function () use ($regions) {
                $this->query->whereHas('regions', function ($que) use ($regions) {
                    $que->whereIn('code', $regions);
                });
            });
        });
        if ($type == 'countTransportLotsChannel') {
            $cachedCount = Cache::get($type);
            $limit = 10;
            if (isset($cachedCount)) {
                $limit -= $cachedCount;
            }
            $lots = $lots->limit($limit)->get();
            $count = $lots->count() + $cachedCount;
            Cache::put($type, $count, Carbon::now()->setTimezone('Europe/Moscow')->endOfDay());
        } else {
            $lots = $lots->get();
        }
        $offers= ['ClosePublicOffer', 'PublicOffer', "PPZ", "PPU"];
        foreach ($lots as $lot) {
            $url = URL::to('/lot/' . $lot->id);
            $lotDesc = mb_strimwidth($lot->description, 0, 250, "...");
            $price = number_format($lot->start_price, 2, ',', ' ');
            $tradeType = $lot->auction->auctionType->description;
            $html = str_replace('<br>', '', str_replace('</p>', '', str_replace('<p>', '',
                "<p>$lotDesc</p>
<strong>Начальная цена: $price ₽</strong>")));
            if (in_array($lot->auction->auctionType->title, $offers) && !is_null($lot->min_price)) {
                $min_price = number_format($lot->min_price, 2, ',', ' ');
                $html .= "
<strong>Минимальная цена: $min_price ₽</strong>";
            }
            $html .= "
<strong>Тип торгов: $tradeType</strong>
<a href='$url'>Ссылка на лот</a>";
            $token = config('telegram.bot_token');
            $chat_id = config('telegram.lots_chat_id');
            $client = new Client();
            try {
                $client->post('https://api.telegram.org/bot' . $token . '/sendMessage', [
                    RequestOptions::JSON => [
                        'chat_id' => $chat_id,
                        'text' => $html,
                        'parse_mode' => 'html'
                    ]
                ]);
            } catch (ClientException $e) {
                if ($e->getResponse()->getStatusCode() === 429) {
                    $retryAfter = $e->getResponse()->getHeader('retry-after')[0] ?? 60;
                    sleep($retryAfter);
                } else {
                    logger($e->getMessage());
                }
            } catch (\Exception $e) {
                logger($e->getMessage());
            }
        }
    }

    public function sendLotsToClients() {
        try {
            if(!Cache::has('botTrialPeriod')){
                $cacheService = new CacheService();
                $cacheService->cacheBotTrialPeriod();
            }
            $botTestPeriodInDays = Cache::get('botTrialPeriod');

            //получаем пользователей с активным тарифом и сохраненными фильтрами
            $users = User::select([
                'users.id',
                'users.tg_id',
                'users_bot_filters.filters'
            ])
                ->leftJoin('users_bot_filters', 'users_bot_filters.user_id', '=', 'users.id')
                ->leftJoin('payments', 'payments.user_id', '=', 'users.id')
                ->leftJoin('tariffs', 'tariffs.id', '=', 'payments.tariff_id')
                ->where(function($query) use($botTestPeriodInDays) {
                    $query->where(function ($q) {
                        $q->where('payments.tariff_id', '!=', null)
                            ->where('payments.is_confirmed', true)
                            ->where('payments.status', 'Settled')
                            ->where('payments.finished_at', '>=', Carbon::now()->setTimezone('Europe/Moscow'))
                            ->where('tariffs.type', 'bot_tariff');
                    })->orWhere('users.tg_connected_at', '>=', Carbon::now()->subDays($botTestPeriodInDays)->setTimezone('Europe/Moscow'));
                })
                ->where('tg_id', '!=', null)
                ->where('users_bot_filters.filters', '!=', null)
                ->groupBy('users.id')
                ->get();

            if(count($users)) {
                //получаем все лоты добавленные за час
                $minDate = Carbon::now()->setTimezone('Europe/Moscow')->subHours(1)->startOfHour();
                $maxDate = Carbon::now()->setTimezone('Europe/Moscow')->startOfHour();
                $lots = DB::table('lots')
                    ->select([
                        'lots.id',
                        'lots.description',
                        'lots.start_price',
                        'lots.min_price',
                        'lots.auction_id',

                        'categories.id as category_id',
                        'categories.title as category_title',

                        'regions.id as region_id',
                        'regions.code as region_code',

                        'price_reductions.id as price_reductions_id',
                        'price_reductions.price',
                        'price_reductions.start_time',
                        'price_reductions.end_time',
                        'price_reductions.deposit',
                        'price_reductions.percent',

                        'auction_types.id as auction_type_id',
                        'auction_types.title as auction_type_title',
                        'auction_types.description as auction_type_description'
                    ])
                    ->leftJoin('lot_categories', 'lot_categories.lot_id', '=', 'lots.id')
                    ->leftJoin('categories', 'lot_categories.category_id', '=', 'categories.id')
                    ->leftJoin('lot_regions', 'lot_regions.lot_id', '=', 'lots.id')
                    ->leftJoin('regions', 'lot_regions.region_id', '=', 'regions.id')
                    ->leftJoin('price_reductions', function ($join) use ($maxDate) {
                        $join->on('price_reductions.lot_id', '=', 'lots.id')
                            ->where('price_reductions.start_time', '<', $maxDate)
                            ->where(function ($query) use ($maxDate) {
                                $query->where('price_reductions.end_time', '>=', $maxDate)
                                    ->orWhereNull('price_reductions.end_time');
                            })
                            ->where('price_reductions.start_time', DB::raw('(SELECT max(price_reductions.start_time) FROM price_reductions as pr WHERE pr.lot_id = lots.id'
                                . ' AND (pr.start_time < "' . $maxDate . '" AND (pr.end_time >= "' . $maxDate . '" OR pr.end_time is NULL)) LIMIT 1)'))
                            ->orderBy('price_reductions.end_time', 'desc')
                            ->orderBy('price_reductions.id', 'desc');
                    })
                    ->leftJoin('auctions', 'lots.auction_id', '=', 'auctions.id')
                    ->leftJoin('auction_types', 'auctions.auction_type_id', '=', 'auction_types.id')
                    ->whereBetween('lots.created_at', [$minDate, $maxDate])
                    ->get();

                $priceKeys = [
                    'currentPrice' => 'price',
                    'minPrice' => 'min_price',
                    'percentageReduction' => 'percent',
                    'startPrice' => 'start_price',
                ];

                $lotsToSend = [];
                // для каждого клиента отбираем лоты по его фильтрам
                foreach ($users as $user) {
                    $userLots = $lots;
                    $userFilters = $user->filters;
                    if (isset($userFilters['regions']) && count($userFilters['regions'])) {
                        $userLots = $userLots->whereIn('region_code', $userFilters['regions']);
                    }
                    if (isset($userFilters['categories']) && count($userFilters['categories'])) {
                        $userLots = $userLots->whereIn('category_title', $userFilters['categories']);
                    }
                    if (isset($userFilters['mainParams']['tradeTypes']) && count($userFilters['mainParams']['tradeTypes'])) {
                        $userLots = $userLots->whereIn('auction_type_title', $userFilters['mainParams']['tradeTypes']);
                    }
                    if (isset($userFilters['price'])) {
                        foreach ($userFilters['price'] as $key => $value) {
                            $min = $value['min'];
                            $max = $value['max'];
                            if (isset($min) && $min != null) {
                                $userLots = $userLots->where($priceKeys[$key], '>=', $min);
                            }
                            if (isset($max) && $max != null) {
                                $userLots = $userLots->where($priceKeys[$key], '<=', $max);
                            }
                        }
                    }
                    $userLots = $userLots->unique('id')->take(30)->values();
                    if(count($userLots)) {
                        foreach ($userLots as $lot) {
                            $lotToSend = $lot;
                            $lotToSend->tg_id = $user->tg_id;
                            //добавляем отфильтрованные лоты в общий список на отправку
                            $lotsToSend[] = $lotToSend;
                        }
                    }
                }

                // если есть лоты на отправку в чаты, следим, чтобы не нарушить 30сообщений в секунду
                if(count($lotsToSend)) {
                    $start = microtime(true);
                    $index = 0;
                    foreach ($lotsToSend as $lot) {
                        $index++;
                        try {
                            $this->sendMessage($lot,$lot->auction_type_description,$lot->auction_type_title);
                        } catch (ClientException $e) {
                            if ($e->getResponse()->getStatusCode() === 429) {
                                $retryAfter = $e->getResponse()->getHeader('retry-after')[0] ?? 60;
                                sleep($retryAfter);
                            }
                        }
                        if ($index % 30 == 0) {
                            $end = microtime(true);
                            try {
                                $sleep = 1 - ($end - $start);
                                if ($sleep > 0) {
                                    sleep($sleep);
                                }
                            } catch (\Exception $e) {
                            }
                            $start = microtime(true);
                        }
                    }
                }
            }
        }
        catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function sendMessage($lot, $tradeType, $auctionType) {
        $url = URL::to('/lot/' . $lot->id);
        $lotDesc = mb_strimwidth($lot->description, 0, 250, "...");
        $price = number_format($lot->start_price, 2, ',', ' ');
        $html = str_replace('<br>', '', str_replace('</p>', '', str_replace('<p>', '',
            "<p>$lotDesc</p>
<strong>Начальная цена: $price ₽</strong>")));
        $offers = ['ClosePublicOffer', 'PublicOffer', "PPZ", "PPU"];
        if (in_array($auctionType, $offers) && !is_null($lot->min_price)) {
            $min_price = number_format($lot->min_price, 2, ',', ' ');
            $html .= "
<strong>Минимальная цена: $min_price ₽</strong>";
        }
        $html .= "
<strong>Тип торгов: $tradeType</strong>
<a href='$url'>Ссылка на лот</a>";

        $message = Telegram::sendMessage([
            'chat_id' => $lot->tg_id,  // The ID of the chat to send the message to
            'text' => $html,  // The message text to send
            'parse_mode' => 'html'
        ]);
    }

}
