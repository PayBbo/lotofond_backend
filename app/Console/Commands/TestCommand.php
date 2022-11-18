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
        $startDate = Carbon::parse('2022-11-18 00:00');
        $endDate = Carbon::parse('2022-11-18 14:00');
        while ($startDate < $endDate) {
            $startFrom = $startDate->format('Y-m-d\TH:i:s');
            $startDate->addHours(2);
            dispatch(new ParseTrades($startFrom, $startDate->format('Y-m-d\TH:i:s')));
        }
        // dispatch(new ParseTrades);
        //$get_trade_message_content = new GetTradeMessageContent($xml, 'BiddingInvitation');
        //$get_trade_message_content->switchMessageType(1, $xml, 13275260);
        /* $soapWrapper = new SoapWrapper();
          $service = new SoapWrapperService($soapWrapper);
          $xml = $service->getTradeMessageContent(13524515);
          logger($xml);*/
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
