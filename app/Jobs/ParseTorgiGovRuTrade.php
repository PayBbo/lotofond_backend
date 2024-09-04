<?php

namespace App\Jobs;

use App\Models\Auction;
use App\Models\Lot;
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
    protected $status;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($notice=null, $status=null)
    {
        $this->notice = $notice;
        $this->status = $status;
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
                $this->parseAuction($auction, $documentType, $subjectRightHolderCode);
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
        if($this->status) {
            $statuses = ['noticeCancel', 'noticeStop', 'noticeResumption', 'noticeAnnulment'];
            $item = $this->callMethod('', [], $this->status['href']);
            $auction = Auction::where('trade_id', $this->status['regNum'])->first();
            if ($auction) {
                $files = $this->parseFiles($item);
                $lots = Lot::where('auction_id', $auction->id)->get();
                foreach ($lots as $lot) {
                    $this->storeFiles($files, $auction->id, $lot->id);
                    if (in_array($this->status['documentType'], $statuses)) {
                        $lot->status_id = $this->parseStatus($this->status['documentType']);
                        $lot->save();
                    }
                }
//                Lot::where('auction_id', $auction->id)->update([
//                    'status_id' => $this->parseStatus($this->status['documentType'])
//                ]);
            }
        }
    }
}
