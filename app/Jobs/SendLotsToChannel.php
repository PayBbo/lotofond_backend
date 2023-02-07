<?php

namespace App\Jobs;

use App\Models\Lot;
use App\Models\Region;
use App\Notifications\ApplicationTelegramNotification;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

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
        $lots = $this->query->where(function ($query) use ($regions){
            $query->whereHas('objectRegions', function ($q) use ($regions) {
                $q->whereIn('code', $regions);
            })->orWhereDoesntHave('objectRegions', function () use ($regions) {
                $this->query->whereHas('regions', function ($que) use ($regions) {
                    $que->whereIn('code', $regions);
                });
            });
        });
        if($type == 'countTransportLotsChannel'){
            $cachedCount = Cache::get($type);
            $limit = 10;
            if (isset($cachedCount)) {
                $limit -= $cachedCount;
            }
            $lots = $lots->limit($limit)->get();
            $count = $lots->count() + $cachedCount;
            Cache::put($type, $count, Carbon::now()->setTimezone('Europe/Moscow')->endOfDay());
        }else{
            $lots = $lots->get();
        }
        foreach ($lots as $lot) {
            $url = URL::to('/lot/' . $lot->id);
            $lotDesc = mb_strimwidth($lot->processed_description, 0, 250, "...");
            $price = number_format($lot->start_price, 2, ',', ' ');
            $tradeType = $lot->auction->auctionType->description;
            $html = str_replace('<br>', '', str_replace('</p>', '', str_replace('<p>', '',
                "<p>$lotDesc</p>
<strong>Начальная цена: $price ₽</strong>")));
            if (($lot->auction->auctionType->title == 'PublicOffer' || $lot->auction->auctionType->title == 'ClosePublicOffer') && !is_null($lot->min_price)) {
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
                sleep(1);
            } catch (\Exception $e) {
                logger($e->getMessage());
            }
        }
    }
}
