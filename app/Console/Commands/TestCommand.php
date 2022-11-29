<?php

namespace App\Console\Commands;


use App\Http\Services\Parse\GetTradeMessageContent;
use App\Http\Services\Parse\ParseDataFromRosreestrService;
use App\Http\Services\Parse\SoapWrapperService;
use App\Jobs\ChangeEmail;
use App\Jobs\FavouriteJob;
use App\Jobs\MonitoringJob;
use App\Jobs\MonitoringNotificationJob;
use App\Jobs\ParseArbitrManager;
use App\Jobs\ParseDebtorMessages;
use App\Jobs\ParseTrades;
use App\Jobs\SendLotsToChannel;
use App\Models\Bidder;
use App\Models\BiddingResult;
use App\Models\Lot;
use App\Models\Notification;
use App\Models\Param;
use App\Models\PriceReduction;
use App\Models\User;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;


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
      /*  Cache::forget('countRealtyLotsChannel');
        Cache::forget('countTransportLotsChannel');
        dispatch(new SendLotsToChannel);*/
        //dispatch(new FavouriteJob);
        //    dispatch(new MonitoringJob);
        //  dispatch(new MonitoringNotificationJob('hourly'));
        //dispatch(new ParseDebtorMessages);
     /*   $startDate = Carbon::parse('2022-11-24 00:00');
        $endDate = Carbon::parse('2022-11-24 12:00');
        while ($startDate < $endDate) {
            $startFrom = $startDate->format('Y-m-d\TH:i:s');
            $startDate->addHours(3);
            dispatch((new ParseTrades($startFrom, $startDate->format('Y-m-d\TH:i:s')))->onQueue('parse'));
        }*/
        // dispatch(new ParseTrades);
        //$get_trade_message_content = new GetTradeMessageContent($xml, 'BiddingInvitation');
        //$get_trade_message_content->switchMessageType(1, $xml, 13275260);
        /* $soapWrapper = new SoapWrapper();
          $service = new SoapWrapperService($soapWrapper);
          $xml = $service->getTradeMessageContent(13524515);
          logger($xml);*/
   /*      $soapWrapper = new SoapWrapper();
         $service = new SoapWrapperService($soapWrapper);
         logger(json_encode($service->getTradeMessagesByTrade( '140376', '1656057203', Carbon::parse('2022-09-06 13:00:00')->format('Y-m-d\TH:i:s'))));*/

    }
}
