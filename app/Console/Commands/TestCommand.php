<?php

namespace App\Console\Commands;


use App\Http\Services\Parse\GetTradeMessageContent;
use App\Http\Services\Parse\SoapWrapperService;
use App\Jobs\ChangeEmail;
use App\Jobs\FavouriteJob;
use App\Jobs\MonitoringJob;
use App\Jobs\MonitoringNotificationJob;
use App\Jobs\ParseArbitrManager;
use App\Jobs\ParseTrades;
use App\Models\Bidder;
use App\Models\BiddingResult;
use App\Models\Lot;
use App\Models\Notification;
use App\Models\PriceReduction;
use App\Models\User;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Carbon\Carbon;
use Illuminate\Console\Command;


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

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //dispatch(new FavouriteJob);
     //    dispatch(new MonitoringJob);
       //  dispatch(new MonitoringNotificationJob('hourly'));
        //dispatch(new ParseArbitrManager);
        /* $startDate = Carbon::parse('2022-08-17 00:30');
         $endDate = Carbon::parse('2022-09-07 00:40');
         while($startDate < $endDate){
             $startFrom = $startDate->format('Y-m-d\TH:i:s');
             $startDate->addHours(3);
             dispatch(new ParseTrades($startFrom, $startDate->format('Y-m-d\TH:i:s')));
         }*/
        // dispatch(new ParseTrades);
        //$get_trade_message_content = new GetTradeMessageContent($xml, 'BiddingInvitation');
        //$get_trade_message_content->switchMessageType(1, $xml, 13275260);
       /*  $soapWrapper = new SoapWrapper();
         $service = new SoapWrapperService($soapWrapper);
         $xml = $service->getTradeMessageContent(13332187);
         logger($xml);*/
    /*    $lot = Lot::find(17482);
        $red = '&lt;table&gt;&lt;thead&gt;&lt;tr&gt;&lt;th&gt;Дата и время начала периода&lt;/th&gt;&lt;th&gt;Дата и время начала подачи пердложений&lt;/th&gt;&lt;th&gt;Дата и время окончания предложений&lt;/th&gt;&lt;th&gt;Дата и время окончания периода&lt;/th&gt;&lt;th&gt;Размер задатка, руб&lt;/th&gt;&lt;th&gt;Снижение цены&lt;/th&gt;&lt;/tr&gt;&lt;/thead&gt;&lt;tbody&gt;&lt;tr&gt;&lt;td&gt;26.09.2022 09:00:00&lt;/td&gt;&lt;td&gt;26.09.2022 09:00:00&lt;/td&gt;&lt;td&gt;02.10.2022 23:59:00&lt;/td&gt;&lt;td&gt;02.10.2022 23:59:00&lt;/td&gt;&lt;td&gt;6 700 608,00&lt;/td&gt;&lt;td&gt;33 503 040,00&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;03.10.2022 00:00:00&lt;/td&gt;&lt;td&gt;03.10.2022 00:00:00&lt;/td&gt;&lt;td&gt;09.10.2022 23:59:00&lt;/td&gt;&lt;td&gt;09.10.2022 23:59:00&lt;/td&gt;&lt;td&gt;6 030 547,20&lt;/td&gt;&lt;td&gt;30 152 736,00&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;10.10.2022 00:00:00&lt;/td&gt;&lt;td&gt;10.10.2022 00:00:00&lt;/td&gt;&lt;td&gt;16.10.2022 23:59:00&lt;/td&gt;&lt;td&gt;16.10.2022 23:59:00&lt;/td&gt;&lt;td&gt;5 360 486,40&lt;/td&gt;&lt;td&gt;26 802 432,00&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;17.10.2022 00:00:00&lt;/td&gt;&lt;td&gt;17.10.2022 00:00:00&lt;/td&gt;&lt;td&gt;23.10.2022 23:59:00&lt;/td&gt;&lt;td&gt;23.10.2022 23:59:00&lt;/td&gt;&lt;td&gt;4 690 425,60&lt;/td&gt;&lt;td&gt;23 452 128,00&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;24.10.2022 00:00:00&lt;/td&gt;&lt;td&gt;24.10.2022 00:00:00&lt;/td&gt;&lt;td&gt;30.10.2022 23:59:00&lt;/td&gt;&lt;td&gt;30.10.2022 23:59:00&lt;/td&gt;&lt;td&gt;4 020 364,80&lt;/td&gt;&lt;td&gt;20 101 824,00&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;31.10.2022 00:00:00&lt;/td&gt;&lt;td&gt;31.10.2022 00:00:00&lt;/td&gt;&lt;td&gt;06.11.2022 23:59:00&lt;/td&gt;&lt;td&gt;06.11.2022 23:59:00&lt;/td&gt;&lt;td&gt;3 350 304,00&lt;/td&gt;&lt;td&gt;16 751 520,00&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;';
        if (str_starts_with($red, '&lt;table&gt;&lt;')) {
            $red = htmlspecialchars_decode($red);
        }

       if (str_starts_with($red, '<table><thead><tr><th>')) {
            $pattern = '/<tr[\s\S]*?<\/tr>/';
            preg_match_all($pattern, $red, $matches);
            if (count($matches[0]) > 0) {
                unset($matches[0][0]);
                $i = 0;
                foreach ($matches[0] as $match) {
                    $new_pattern = '/<td[\s\S]*?<\/td>/';
                    preg_match_all($new_pattern, $match, $items);
                    $start_time = substr($items[0][0], 4, strlen($items[0][0]) - 9);
                    $end_time = substr($items[0][3], 4, strlen($items[0][3]) - 9);
                    $price = number_format((float)preg_replace("/[^,.0-9]/", '',
                        str_replace(',', '.',
                            substr($items[0][5], 4, strlen($items[0][5]) - 9)
                        )), 2, '.', '');
                    $deposit = number_format((float)preg_replace("/[^,.0-9]/", '',
                        str_replace(',', '.',
                            substr($items[0][4], 4, strlen($items[0][4]) - 9)
                        )), 2, '.', '');
                    if ($i > 1) {
                        preg_match_all($new_pattern, $matches[0][$i - 1], $prev_item);
                        $prev_price = (float)preg_replace("/[^,.0-9]/", '',
                            str_replace(',', '.',
                                substr($prev_item[0][5], 4, strlen($prev_item[0][5]) - 9))
                        );
                    } else {
                        $prev_price = $lot->start_price;
                    }
                    if (date('Y-m-d H:i:s', strtotime($start_time) == $start_time) && $price > 0
                        && date('Y-m-d H:i:s', strtotime($end_time) == $end_time)) {
                        if (!is_null($prev_price)) {
                            $percent = ((float)$prev_price / (float)$price) * 100 - 100;
                        }
                        PriceReduction::create([
                            'lot_id' => $lot->id,
                            'price' => $price,
                            'start_time' => $start_time,
                            'end_time' => $end_time,
                            'percent' => $percent,
                            'deposit' => $deposit,
                            'is_system' => false
                        ]);
                    }
                    $i++;
                }
            }
        }*/
        /* $soapWrapper = new SoapWrapper();
         $service = new SoapWrapperService($soapWrapper);
         $debtor_data = get_object_vars($service->searchDebtorByCode( 'CompanyInn', 5610112272));
         if (array_key_exists('DebtorCompany', $debtor_data)) {
             if(gettype($debtor_data['DebtorCompany']) == 'array'){
                 $debtor = $debtor_data['DebtorCompany'];
             }else {
                 $debtor = get_object_vars($debtor_data['DebtorCompany']);
             }
         }
         if(!array_key_exists('INN', $debtor)){
             logger(get_object_vars(array_pop($debtor))['INN']);
         }else {
             logger($debtor['INN']);
         }*/



    }
}
