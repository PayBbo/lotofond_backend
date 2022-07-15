<?php

namespace App\Http\Services\Parse;

use App\Http\Services\Parse\TradeMessages\ApplicationSession;
use App\Http\Services\Parse\TradeMessages\BiddingInvitation;
use App\Http\Services\Parse\TradeMessages\BiddingStatusInfo;
use App\Models\TradeMessage;
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
            if($type == 'ErrorMessage'){
                $type = 'SystemInfo';
            }
            if($type == 'Annulment'){
                $nextType .='Message';
            }
            if (array_key_exists('ns1:Set' . $type, $xml[$key[0]])) {
                $this->invitation = $xml[$key[0]]['ns1:Set' . $type]['ns1:' . $nextType];
                $this->prefix = 'ns1:';
            } else {
                $this->invitation = $xml[$key[0]]['Set' . $type][$nextType];
                $this->prefix = '';
            }
        } catch (\Exception $e) {
            logger($xml);
        }
    }

    public function switchMessageType($tradePlace, $trade, $id)
    {
        if (!TradeMessage::where('number', $id)->exists()) {
            if ($this->messageType == 'BiddingInvitation') {
                //$biddingInvitation = new BiddingInvitation($this->invitation, $this->prefix, 'biddingDeclared', $id);
               // $biddingInvitation->response($tradePlace, $trade);

            } elseif($this->messageType == 'BiddingEnd' || $this->messageType == 'BiddingStart' ||
                $this->messageType == 'ApplicationSessionEnd' || $this->messageType == 'ApplicationSessionStart') {
                $applicationSession = new ApplicationSession($this->invitation, $this->prefix, $this->messageType, $id);
                $applicationSession->response();
            } elseif ($this->messageType == 'BiddingCancel' || $this->messageType == 'BiddingFail' ||
                $this->messageType == 'BiddingPause' || $this->messageType == 'BiddingResume') {
                $biddingStatusInfo = new BiddingStatusInfo($this->invitation, $this->prefix, $this->messageType, $id);
                $biddingStatusInfo->response();
            } else {
                $class = 'App\Http\Services\Parse\TradeMessages\\' . $this->messageType;
                (new $class($this->invitation, $this->prefix, $this->messageType, $id))->response();
            }
        }

    }


}
