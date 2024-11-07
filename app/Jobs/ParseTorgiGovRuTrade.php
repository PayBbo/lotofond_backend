<?php

namespace App\Jobs;

use App\Models\Auction;
use App\Models\Lot;
use App\Models\TradeMessage;
use App\Traits\TorgiGovRuTrait;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
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
                $parse = $item;
                if (isset($item['exportObject'])) {
                    $parse = $parse['exportObject'];
                    if (isset($parse['structuredObject'][$this->status['documentType']])) {
                        $parse = $parse['structuredObject'][$this->status['documentType']];
                    }
                    if (isset($parse['commonInfo'])) {
                        $parse = array_merge($parse, $parse['commonInfo']);
                    }
                }
                $files = $this->parseFiles($parse);
                $lots = Lot::where('auction_id', $auction->id)->get();
                foreach ($lots as $lot) {
                    $this->storeFiles($files, $auction->id, $lot->id);
                    if (in_array($this->status['documentType'], $statuses)) {
                        $lot->status_id = $this->parseStatus($this->status['documentType']);
                        $lot->save();

                        try {
                            $type = strtolower(str_replace("notice", "", $this->status['documentType']));
                            TradeMessage::create([
                                'lot_id' => $lot->id,
                                'value' =>  $this->parseStatusName($this->status['documentType']),
                                'number' => $this->status['documentType'].'_'.$lot->id,
                                'text' => isset($parse[$type.'Reason']['name']) ? $parse[$type.'Reason']['name'] : null,
                                'date' => isset($parse['publishDate']) ? Carbon::parse($parse['publishDate'])->setTimezone('Europe/Moscow') : null,
                                'param' => $lot->status_id,
                                'param_type' => 'status_id',
                                'created_at' => Carbon::now()->setTimezone('Europe/Moscow'),
                                'guid'=> isset($parse['id']) ? $parse['id'] : null
                            ]);
                        }
                        catch (\Exception $e) {
                        }
                    }
                }
//                Lot::where('auction_id', $auction->id)->update([
//                    'status_id' => $this->parseStatus($this->status['documentType'])
//                ]);
            }
        }
    }
}
