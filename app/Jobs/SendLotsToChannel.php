<?php

namespace App\Jobs;

use App\Models\Lot;
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
        if (Cache::get($realtyType) < 10) {
            $this->sendLots($realtyCategories, $realtyType);
        }
        if (Cache::get($transportType) < 10) {
            $this->sendLots($transportCategories, $transportType);
        }

    }

    public function sendLots($categories, $type)
    {
        $minDate = Carbon::now()->setTimezone('Europe/Moscow')->subHour();
        $maxDate = Carbon::now()->setTimezone('Europe/Moscow');
        $cachedCount = Cache::get($type);
        $limit = 10;
        if (isset($cachedCount)) {
            $limit -= $cachedCount;
        }
        $lots = Lot::whereBetween('lots.created_at', [$minDate, $maxDate])
            ->whereHas('categories', function ($query) use ($categories) {
                $query->whereIn('title', $categories);
            })->limit($limit)->get();
        $count = $lots->count() + $cachedCount;
        Cache::put($type, $count, Carbon::now()->setTimezone('Europe/Moscow')->endOfDay());
        foreach ($lots as $lot) {
            $url = URL::to('/lot/' . $lot->id);
            $lotDesc = mb_strimwidth($lot->description, 0, 250, "...");
            $price = number_format($lot->start_price, 2, ',', ' ');
            $html =  str_replace('<br>', '',  str_replace('</p>', '', str_replace('<p>', '',
                "<strong>Описание лота:</strong>
<p>$lotDesc</p>
<strong>Начальная цена: $price ₽</strong>" )));
            if($lot->auction->auctionType->title =='PublicOffer' || $lot->auction->auctionType->title =='ClosePublicOffer'){
                $min_price = number_format($lot->min_price, 2, ',', ' ');
                $html .="
<strong>Минимальная цена: $min_price ₽</strong>";
            }
            $html.="
<a href='$url'>Ссылка на лот</a>";
            $token = config('telegram.lots_bot_token');
            $chat_id =  config('telegram.lots_chat_id');
            $client = new Client();
            try {
                $client->post('https://api.telegram.org/bot'.$token.'/sendMessage', [
                    RequestOptions::JSON => [
                        'chat_id' => $chat_id,
                        'text' => $html,
                        'parse_mode'=>'html'
                    ]
                ]);
            } catch (\Exception $e) {
                logger($e->getMessage());
            }
        }
    }
}
