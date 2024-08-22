<?php

namespace App\Jobs;

use App\Http\Services\CacheService;
use App\Traits\TorgiGovRuTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ParseTorgiGovRu implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, TorgiGovRuTrait;

    protected $startFrom;
    protected $endTo;
    protected $type;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($type='all',$startFrom=null, $endTo=null)
    {
        $this->type = $type;
        $this->startFrom = $startFrom;
        $this->endTo = $endTo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        logger('START ParseTorgiGovRu:'. $this->type . ' from: '.$this->startFrom);
        if($this->type === 'all') {
            $this->getLastNotices();
        }
        else {
            $this->getCurrentNotices($this->startFrom, $this->endTo);
        }
        $this->finishJob();
    }

    private function finishJob(){
        $cacheService = new CacheService();
        $cacheService->cacheCategoriesStatistics();
        $cacheService->cacheLotsStatistics();
        $cacheService->cachePricesForFilter();
        dispatch((new MonitoringJob())->onQueue('monitoring'));
        logger('END ParseTorgiGovRu to: ' .$this->endTo);
    }
}
