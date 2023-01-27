<?php

namespace App\Console\Commands;


use App\Http\Services\Parse\DescriptionExtractsService;
use App\Http\Services\Parse\FilesService;
use App\Http\Services\Parse\GetTradeMessageContent;
use App\Http\Services\Parse\ParseDataFromRosreestrService;
use App\Http\Services\Parse\SoapWrapperService;
use App\Http\Services\PushNotificationService;
use App\Http\Services\ReestrApiService;
use App\Http\Services\SendCodeService;
use App\Jobs\ChangeEmail;
use App\Jobs\FavouriteJob;
use App\Jobs\MakeProcessedDescription;
use App\Jobs\MonitoringJob;
use App\Jobs\MonitoringNotificationJob;
use App\Jobs\ParseArbitrManager;
use App\Jobs\ParseDebtorMessages;
use App\Jobs\ParseTrades;
use App\Jobs\SendApplication;
use App\Jobs\SendLotsToChannel;
use App\Models\Bidder;
use App\Models\BiddingResult;
use App\Models\Contact;
use App\Models\EgrnStatement;
use App\Models\HolidayDate;
use App\Models\Lot;
use App\Models\LotParam;
use App\Models\Notification;
use App\Models\Param;
use App\Models\PriceReduction;
use App\Models\Region;
use App\Models\TestMessage;
use App\Models\User;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Exception;
use GuzzleHttp\RequestOptions;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Midnite81\Xml2Array\Xml2Array;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\MessageFormatter;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected $regexs = [
        '([АВЕКМНОРСТУХавекмнорстухABEKMHOPCTYXaeopcyx][ ]?\d{3}(?<!000)[ ]?[АВЕКМНОРСТУХавекмнорстухABEKMHOPCTYXaeopcyx]{2})', //Обычные
        '(?:(?:([АВЕКМНОРСТУХавекмнорстухABEKMHOPCTYXaeopcyx]{2}[ ]?\d{4}(?<!0000)))|(?:(\d{4}[ ]?(?<!0000)[АВЕКМНОРСТУХавекмнорстухABEKMHOPCTYXaeopcyx]{2})))', //Прицеп/мотоциклы/внедорожные мототранспортные средства
        '([АВЕКМНОРСТУХавекмнорстухABEKMHOPCTYXaeopcyx]{2}[ ]?\d{2}(?<!00)[ ]?[АВЕКМНОРСТУХавекмнорстухABEKMHOPCTYXaeopcyx]{2})', //Мопеды
        '([АВЕКМНОРСТУХавекмнорстухABEKMHOPCTYXaeopcyx]{2}[ ]?\d{3}(?<!000))', //Такси
        '(\d{4}[ ]?(?<!0000)[АВЕКМНОРСТУХавекмнорстухABEKMHOPCTYXaeopcyx]{2})', //Военные
        '(([TtТт])([АВЕКМНОРСТУХавекмнорстухABEKMHOPCTYXaeopcyx]{2}[ ]?\d{3}(?<!000)))', //Окончательно выезжающие за пределы РФ
        '(?:(?:(?:([АВЕКМНОРСТУХавекмнорстухABEKMHOPCTYXaeopcyx][ ]?\d{4}(?<!0000)))|(?:((?:(?:\d{3}(?<!000))|(?:\d{4}(?<!0000)))[ ]?(?:[АВЕКМНОРСТУавекмнорстуABEKMHOPCTYaeopcy]|(?<maybe_size>[ХхXx]))))))', //МВД
        '(([KkКк])([АВЕКМНОРСТУХавекмнорстухABEKMHOPCTYXaeopcyx]{2}[ ]?\d{3}(?<!000)))', //Ретро
        '(([CcСс])([АВЕКМНОРСТУХавекмнорстухABEKMHOPCTYXaeopcyx]{2}[ ]?\d{3}(?<!000)))',//Спорт
        '(?:(?:((\d{3})(?<!000)[ ]?((?:[cCсС]{2})|(?:[cCсС][dD]))[ ]?(\d)))|(?:((\d{3})(?<!000)[ ]?([Dd]|[TtТт])[ ]?(\d{3})))|(?:(([Dd]|[TtТт])[ ]?(\d{3})(?<!000)[ ]?(\d{2}))))' //Дипломаты
    ];
    protected $regexStart = '(?:(?:(?:(?:[Рр][Ее][Гг][Ии][Сс][Тт][Рр][Аа][Цц][Ии][Оо][Нн][Нн][Ыы][Йй][ ]?[Зз][Нн][Аа][Кк])|(?:[Гг][\/\\. ]?[ ]?[Нн][.]?)|(?:[Рр][Ее][Гг][.]?[ ]?[Зз][Нн][Аа][Кк][.]?)|(?:[Гг][Оо][Сс][.]?(?:[Уу][Дд][Аа][Рр][Сс][Тт][Вв][Ее][Нн][Нн][Ыы][Йй])?[ ]?[Нн][.]?(?:[Оо][Мм])?[.]?(?:[Ее][Рр])?)|(?:[Гг][.]?[ ]?[Рр][.]?[ ]?[Зз][.]?)|(?:№))[ ]?[:\-–]?[ ]?)|(?:№)|(?<year>(?:19|20)\d\d )|(?<parenthesis>\()|(?<comma>,[ ]?))';
    protected $regexEnd = '(?(parenthesis)(?(maybe_size)(*FAIL))\))(?(comma)(?(maybe_size)(*FAIL))(?:,|\.|\n|\z))(?(year)(?(maybe_size)(*FAIL))(?:,|\.| |\n|\z))';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /*  Cache::forget('countRealtyLotsChannel');
          Cache::forget('countTransportLotsChannel');
          dispatch(new SendLotsToChannel);*/
        //dispatch(new FavouriteJob);
        //    dispatch(new MonitoringJob);
        //  dispatch(new MonitoringNotificationJob('hourly'));
        //dispatch(new ParseDebtorMessages);
           $startDate = Carbon::parse('2023-01-26 20:00');
           $endDate = Carbon::parse('2023-01-27 00:00');
           while ($startDate < $endDate) {
               $startFrom = $startDate->format('Y-m-d\TH:i:s');
               $startDate->addHours(2);
               dispatch((new ParseTrades($startFrom, $startDate->format('Y-m-d\TH:i:s')))->onQueue('parse'));
           }
        $startDate = Carbon::parse('2023-01-27 14:00');
        $startFrom = $startDate->format('Y-m-d\TH:i:s');
        $startDate->addHour();
        dispatch((new ParseTrades($startFrom, $startDate->format('Y-m-d\TH:i:s')))->onQueue('parse'));
        // dispatch(new ParseTrades);
        //$get_trade_message_content = new GetTradeMessageContent($xml, 'BiddingInvitation');
        //$get_trade_message_content->switchMessageType(1, $xml, 13275260);
     /*     $soapWrapper = new SoapWrapper();
           $service = new SoapWrapperService($soapWrapper);
           //10210474
           $xml = $service->getTradeMessageContent( 13672686);
           logger($xml);*/
    /*    $soapWrapper = new SoapWrapper();
              $service = new SoapWrapperService($soapWrapper);
              logger(json_encode($service->getTradeMessagesByTrade( '100000090', '5610149787', Carbon::parse('2022-09-06 13:00:00')->format('Y-m-d\TH:i:s'))));
*/
        /*  $table = TestMessage::select(
              'message_id',
              'start_price',
              'min_price',
              'auction_step',
              'auction_step_unit',
              'price_reduction',
              'text',
              'price_red_json',
              'period'
          )->get();
          $file = fopen('test_lots.csv', 'w');
          fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
          fputcsv($file, [ 'Номер сообщения', 'Начальная цена', 'Минимальная цена', 'Шаг цены', 'Единица измерения шага цены', 'Снижение цены', 'Текст сообщения', 'Построенный график снижения цена', 'Период (календарные/рабочие дни)'], ';');
          foreach ($table as $row) {
              fputcsv($file, $row->toArray(), ';');
          }
          fclose($file);*/
        /* $minDate = Carbon::parse('2022-12-05 00:00');
         $maxDate = Carbon::parse('2022-12-06 00:00');
         $categories = [
             "land",
             "residentialProperty",
             "commercialRealEstate"
         ];
         $lots = Lot::whereBetween('lots.created_at', [$minDate, $maxDate])
             ->whereHas('categories', function ($query) use ($categories) {
                 $query->whereIn('title', $categories);
             })->count();
         logger($lots);*/

        /* $re = '/(?(DEFINE)(?\'rubles_pattern\'\d{1,3}(?:[ ]?\d{3})*(?:[,]\d{2})*))(?(DEFINE)(?\'rubles_name_pattern\' (?:(?:рублей)|(?:(?:(?:руб)|(?:р))[\.]?))))(?(DEFINE)(?\'percent_pattern\'\d+(?:,\d+)?))(?(DEFINE)(?\'percent_name_pattern\'[ ]?(?:\([а-яёА-ЯЁ]+\))?[ ]?(?:(?:%)|(?:процент(?:ов)?))))(?:(?:(?:(?:минимальн(?:(?:ая)|(?:ой)) цен(?:а|ы))|(?:цен(?:ы|а) отсечения))).*?(?\'new_sentence\'(?:\.[ ][А-ЯЁ]).*?)?(?:(?:(?\'rubles\'(?P>rubles_pattern))(?:(?P>rubles_name_pattern)))|(?:(?\'percent\'(?P>percent_pattern))(?P>percent_name_pattern)))(?![а-яёА-ЯЁ]))|(?:(?:(?:(?\'rubles\'(?P>rubles_pattern))(?:(?P>rubles_name_pattern)))|(?:(?\'percent\'(?P>percent_pattern))(?P>percent_name_pattern)))(?![а-яёА-ЯЁ])(?:[ ]?\((?:(?:цена отсечения)|(?:минимальная цена)).*?\)))/miuJ';
         $str = 'В течение 5 календарных дней со дня публикации сообщения о продаже имущества, цена продажи имущества устанавливается в размере 198 900,00. Впоследствии цена имущества понижается каждые 7 календарных дней на 10%. При этом минимальная цена продажи имущества не может быть ниже 70 % начальной стоимости имущества.';

         preg_match_all($re, $str, $matches);
         logger($matches);*/


        /*  $soapWrapper = new SoapWrapper();
          $service = new SoapWrapperService($soapWrapper);
          $xml = $service->getMessageContent(10229781);
          logger($xml);*/



     //   $regexMinPrice = "/(?(DEFINE)(?'rubles_pattern'\d{1,3}(?:[ ]?\d{3})*(?:[,.]\d{2}))(?'rubles_name_pattern'[ ]?(?:(?:рублей)|(?:(?:(?:руб)|(?:р))[\.]?)))(?'percent_pattern'\d+(?:,\d+)?)(?'percent_name_pattern'[ ]?(?:\([а-яёА-ЯЁ]+\))?[ ]?(?:(?:%)|(?:процент(?:ов)?))))(?:(?:(?:(?:мин(?:имальн(?:(?:ая)|(?:ой)))?[\.]?(?: [А-ЯЁа-яё]+)?[ ](?:(?:цен(?:а|ы))|(?:стоимост(?:ь|и))))|(?:цен(?:ы|а|е) отсечения)|(?:прекращается при достижении))).*?(?'new_sentence'(?:\.[ ](?=[А-ЯЁ])).*?(*SKIP))?(?:(?:(?'rubles'(?P>rubles_pattern))(?:(?P>rubles_name_pattern)))|(?:(?'percent'(?P>percent_pattern))(?P>percent_name_pattern)))(?![а-яёА-ЯЁ]))|(?:(?:(?:(?'rubles'(?P>rubles_pattern))(?:(?P>rubles_name_pattern)))|(?:(?'percent'(?P>percent_pattern))(?P>percent_name_pattern)))(?![а-яёА-ЯЁ])(?:.?[ ]?\((?:(?:цена отсечения)|(?:мин(?:имальная)?[\.]?[ ](?:(?:цена)|(?:стоимость)))).*?\)))/muiJ";
      /*  $regexMinPrice = "/(?(DEFINE)(?'rubles_pattern'\d{1,3}(?:[ ]?\d{3})*(?:[,.]\d{2}))(?'rubles_name_pattern'[ ]?(?:(?:рублей)|(?:(?:(?:руб)|(?:р))[\.]?)))(?'percent_pattern'\d+(?:,\d+)?)(?'percent_name_pattern'[ ]?(?:\([а-яёА-ЯЁ]+\))?[ ]?(?:(?:%)|(?:процент(?:ов)?))))(?:(?:(?:(?:мин(?:имальн(?:(?:ая)|(?:ой)))?[\.]?(?: [А-ЯЁа-яё]+)?[ ](?:(?:цен(?:а|ы))|(?:стоимост(?:ь|и))))|(?:цен(?:ы|а|е) отсечения)|(?:прекращается при достижении))).*?(?'new_sentence'(?:\.[ ](?=[А-ЯЁ])).*?(*SKIP))?(?:(?:(?'rubles'(?P>rubles_pattern))(?:(?P>rubles_name_pattern)))|(?:(?'percent'(?P>percent_pattern))(?P>percent_name_pattern)))(?![а-яёА-ЯЁ]))|(?:(?:(?:(?'rubles'(?P>rubles_pattern))(?:(?P>rubles_name_pattern)))|(?:(?'percent'(?P>percent_pattern))(?P>percent_name_pattern)))(?![а-яёА-ЯЁ])(?:.?[ ]?\((?:(?:цена отсечения)|(?:мин(?:имальная)?[\.]?[ ](?:(?:цена)|(?:стоимость)))).*?\)))/muiJ";
        $str = '';
        preg_match_all($regexMinPrice, $str, $matchesPrice, PREG_SET_ORDER, 0);
        logger($matchesPrice);
        if (count((array)$matchesPrice) > 0 && (array_key_exists('rubles', $matchesPrice[0]) || array_key_exists('percent', $matchesPrice[0]))) {
            $min_price = $this->getMinPrice($matchesPrice, 257081);
            logger($min_price);
        }*/

     /*    $lot = Lot::find(12737);
         $this->getDescriptionExtracts($lot, $lot->description);*/

   /*
       $push = new PushNotificationService('Hello', 'It is test', 23,'system');
        $push->sendPushNotificationToHuawei(['d-9rEG1JTxSw4YoWs9TqBl:APA91bGi_pNsScqSBh5KhPBg8NxvbH-63XjXfM1a8DhJpIZTn2BnBpUyIN8CjUT-sJwb4IDGyawC75QskZAxAHs5IaitZeO0TD9Mt2hot3h9TY7ksQP_IaxD02o-2YWVIy0T_UdD7b4H']);
*/

      /*   $soapWrapper = new SoapWrapper();
            $service = new SoapWrapperService($soapWrapper);
            logger($service->getMessageContent(10595978));*/

        /*$path = 'test-virtual\auction-files';
        $fullpath = 'C:\Users\valer\Desktop\test-virtual\auction-files';
        $testimage = new FilesService();
        $testimage->getImagesFrom($fullpath, $path);*/
    }

    public function getDescriptionExtracts($lot, $description)
    {
        $cadastr_number = '/\d{2}:\d{2}:\d{1,7}:\d{1,}/';
        preg_match_all($cadastr_number, $description, $matches);
        $changeDesc = $description;
        if (count($matches[0]) > 0) {
            foreach (array_unique($matches[0]) as $match) {
                $changeDesc = str_replace($match, str_repeat('░', strlen($match) - 1), $changeDesc);
            }
        }
        $mainParam = new LotParam();
        $mainParam->type = 'transport';
        $mainParam->lot_id = $lot->id;
        $avto_number = '/' . $this->getAvtoNumberRegex() . '/um';
        preg_match_all($avto_number, $description, $matches);
        if (count($matches['licence_plate']) > 0) {
            foreach (array_unique($matches['licence_plate']) as $match) {
                $changeDesc = str_replace($match, str_repeat('░', strlen($match) - 1), $changeDesc);
            }
        }
        $avto_vin = '/[A-HJ-NPR-Z0-9]{17}/ui';
        preg_match_all($avto_vin, $description, $matches);
        if (count($matches[0]) > 0) {
            foreach (array_unique($matches[0]) as $match) {
                $changeDesc = str_replace($match, str_repeat('░', strlen($match) - 1), $changeDesc);
            }
        }
        $lot->processed_description = $changeDesc;
        $lot->save();
    }

    public function getAvtoNumberRegex()
    {
        $result = $this->regexStart . '(?<licence_plate>(?:';
        $regexs = $this->regexs;
        $last_regex = end($regexs);
        foreach ($regexs as $regex) {
            if ($regex !== $last_regex) {
                $result .= '(?:' . $regex . ')|';
            } else {
                $result .= '(?:' . $regex . ')';
            }
        }
        $result .= ')(?:[ ]?(\d{2,3}(?<!(00)|(000)))(?:[ \/\\\\]?(RUS|rus))?))' . $this->regexEnd;
        return $result;
    }

    public function getMinPrice($matchesPrices, $startPrice)
    {
        $min_price = null;
        $result = [];
        foreach($matchesPrices as $matchesPrice) {
            if (array_key_exists('rubles', $matchesPrice) && strlen($matchesPrice['rubles']) > 0) {
                $result[] = (double)str_replace(',', '.', str_replace(' ', '', $matchesPrice['rubles']));
            }
            if (array_key_exists('percent', $matchesPrice) && strlen($matchesPrice['percent']) > 0) {
                $percent = (float)$matchesPrice['percent'];
                $result[] = (double)$startPrice / 100 * $percent;
            }
        }
        $result = array_unique($result);
        if(count($result) == 1){
            $min_price = $result[0];
        }
        return $min_price;
    }


}
