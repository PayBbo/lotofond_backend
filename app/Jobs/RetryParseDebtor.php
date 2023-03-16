<?php

namespace App\Jobs;

use App\Http\Services\Parse\BidderService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RetryParseDebtor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $inn;
    protected $codeType;
    protected $debtorType;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($inn, $codeType, $debtorType)
    {
        $this->inn = $inn;
        $this->codeType = $codeType;
        $this->debtorType = $debtorType;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $bidderParse = new BidderService('debtor', $this->inn, $this->debtorType);
        $bidderParse->parseDebtor($this->codeType);
    }
}
