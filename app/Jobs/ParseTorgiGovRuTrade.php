<?php

namespace App\Jobs;

use App\Traits\TorgiGovRuTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ParseTorgiGovRuTrade implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, TorgiGovRuTrait;

    protected $notice;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($notice=null)
    {
        $this->notice = $notice;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->notice) {
            if(isset($this->notice['href'])) {
                $documentType = isset($this->notice['documentType']) ? $this->notice['documentType'] : null;
                $subjectRightHolderCode = isset($this->notice['subjectRightHolderCode']) ? $this->notice['subjectRightHolderCode'] : null;
                $auction = $this->callMethod('', [], $this->notice['href']);
                $this->parseAuction($auction,$documentType, $subjectRightHolderCode);
            }
            else {
                if(isset($this->notice['noticeNumber'])) {
                    $fullNotice = $this->getAuction($this->notice['noticeNumber']);
                    if($fullNotice) {
                        $this->parseAuction($fullNotice);
                    }
                }
            }
        }
    }
}
