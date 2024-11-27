<?php

namespace App\Console\Commands;

use App\Http\Services\CacheService;
use App\Jobs\MonitoringJob;
use App\Jobs\ParseTorgiGovRuTrade;
use App\Traits\TorgiGovRuTrait;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ParseTorgiGovRuCommand extends Command
{
    use TorgiGovRuTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parseTorgi {--limit=} {--count_statuses=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse torgi.gov.ru for trades';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $limit = 0;
        if ($this->option('limit')) {
            $limit = +$this->option('limit');
        }
        $count_statuses = 0;
        if ($this->option('count_statuses')) {
            $count_statuses = +$this->option('count_statuses');
        }

        logger('START ParseTorgiGovRuCommand');
        $this->info('START ParseTorgiGovRuCommand '.Carbon::now());
        $notices = $this->getNotices();

        if ($notices && count($notices)) {
            $i = 0;
            foreach ($notices as $notice) {
                if ($notice['documentType'] === 'notice') {
                    dispatch((new ParseTorgiGovRuTrade($notice, null))->onQueue('parseTorgi'));
                    $i++;
                }
                else {
                    dispatch((new ParseTorgiGovRuTrade(null, $notice))->onQueue('parseTorgi'));
                    if ($count_statuses) {
                        $i++;
                    }
                }
                if ($limit > 0 && $i === $limit) {
                    break;
                }
            }

        }
        $cacheService = new CacheService();
        $cacheService->cacheCategoriesStatistics();
        $cacheService->cacheLotsStatistics();
        $cacheService->cachePricesForFilter();
        dispatch((new MonitoringJob())->onQueue('monitoring'));
        logger('END ParseTorgiGovRuCommand');
        $this->info('END ParseTorgiGovRuCommand '.Carbon::now());
        return 0;
    }
}
