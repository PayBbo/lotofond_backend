<?php

namespace App\Http\Services\Parse;

use App\Http\Services\Parse\TradeMessages\Annulment;
use App\Http\Services\Parse\TradeMessages\ApplicationSession;
use App\Http\Services\Parse\TradeMessages\BiddingInvitation;
use App\Http\Services\Parse\TradeMessages\BiddingStatusInfo;
use App\Models\Auction;
use App\Models\TradeMessage;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Carbon\Carbon;
use Midnite81\Xml2Array\Xml2Array;
use function logger;

class GetTradeMessageContent
{
    protected $invitation;
    protected $prefix;
    protected $messageType;

    public function __construct($xml, $type)
    {
        try {
            $xml = Xml2Array::create($xml)->toArray();
            $this->messageType = $type;
            $key = preg_grep('/:Body/', array_keys($xml));
            if ($type == 'BiddingProcess') {
                $type .= 'Info';
            }
            $nextType = $type;
            if ($type == 'ErrorMessage') {
                $type = 'SystemInfo';
            }
            if ($type == 'Annulment') {
                $nextType .= 'Message';
            }
            if (array_key_exists('ns1:Set' . $type, $xml[$key[0]])) {
                $this->invitation = $xml[$key[0]]['ns1:Set' . $type]['ns1:' . $nextType];
                $this->prefix = 'ns1:';
            } else {
                $this->invitation = $xml[$key[0]]['Set' . $type][$nextType];
                $this->prefix = '';
            }
        } catch (\Exception $e) {
            logger('GetTradeMessage');
            logger($e);
            logger($xml);
        }
    }

    public function switchMessageType($tradePlace, $id, $messageGUID,  $mustCheck)
    {
        if ($this->messageType == 'BiddingInvitation') {
            $biddingInvitation = new BiddingInvitation($this->invitation, $this->prefix, 'biddingDeclared', $id, $messageGUID);
            $biddingInvitation->response($tradePlace);

        } elseif ($this->messageType == 'Annulment') {
            $annulment = new Annulment($this->invitation, $this->prefix, $this->messageType, $id, $messageGUID);
            $annulment->response();
        } else {
            $searchAuction = null;
            if(!$mustCheck){
                $searchAuction = Auction::where(['trade_id'=> $this->invitation['@attributes']['TradeId'], 'trade_place_id'=>$tradePlace])->first();
            }else {
                $auctions = Auction::where('trade_id', $this->invitation['@attributes']['TradeId'])->get();
                foreach ($auctions as $auction) {
                    try {
                        $soapWrapper = new SoapWrapper();
                        $service = new SoapWrapperService($soapWrapper);
                        $messages = $service->getTradeMessagesByTrade($auction->trade_id, $auction->tradePlace->inn, Carbon::parse($auction->publish_date)->format('Y-m-d\TH:i:s'));
                        $getMessages = new GetTradeMessages($messages);
                        $isAuctionMessage = $getMessages->checkIsAuctionMessage($id);
                        if ($isAuctionMessage) {
                            $searchAuction = $auction;
                            break;
                        }
                    } catch (\Exception $e) {
                        logger('getTradeMessagesByTrade');
                        logger($e);
                    }

                }
            }
            if ($searchAuction) {
                if ($this->messageType == 'BiddingEnd' || $this->messageType == 'BiddingStart' ||
                    $this->messageType == 'ApplicationSessionEnd' || $this->messageType == 'ApplicationSessionStart') {
                    $applicationSession = new ApplicationSession($this->invitation, $this->prefix, $this->messageType, $id, $messageGUID, $searchAuction);
                    $applicationSession->response();
                } elseif ($this->messageType == 'BiddingCancel' || $this->messageType == 'BiddingFail' ||
                    $this->messageType == 'BiddingPause' || $this->messageType == 'BiddingResume') {
                    $biddingStatusInfo = new BiddingStatusInfo($this->invitation, $this->prefix, $this->messageType, $id, $messageGUID, $searchAuction);
                    $biddingStatusInfo->response();
                } else {
                    $class = 'App\Http\Services\Parse\TradeMessages\\' . $this->messageType;
                    (new $class($this->invitation, $this->prefix, $this->messageType, $id, $messageGUID, $searchAuction))->response();
                }
            }
        }
    }


}
