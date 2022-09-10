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
use App\Models\Lot;
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
        //dispatch(new MonitoringJob);
        //dispatch(new MonitoringNotificationJob('weekly'));
        //dispatch(new ParseArbitrManager);
        dispatch(new ParseTrades);
        //$get_trade_message_content = new GetTradeMessageContent($xml, 'BiddingInvitation');
        //$get_trade_message_content->switchMessageType(1, $xml, 13275260);
    }
}
