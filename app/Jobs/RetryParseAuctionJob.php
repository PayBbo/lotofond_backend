<?php

namespace App\Jobs;

use App\Http\Services\Parse\ParseAuctionService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RetryParseAuctionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $auction;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($auction)
    {
        $this->auction = $auction;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        logger('Retry Parse Auction');
        $parseAuction = new ParseAuctionService();
        $parseAuction->parseDataFromAuction($this->auction);
        logger('success');
    }
}
