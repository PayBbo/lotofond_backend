<?php

namespace App\Http\Services\Parse;

use App\Models\Category;
use App\Models\Lot;
use App\Models\LotFile;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Carbon\Carbon;
use Exception;
use Midnite81\Xml2Array\Xml2Array;

class TradeService
{
    protected $value;
    protected $prefix;
    protected $files;
    protected $images;
    protected $lot;
    protected $tradeMessageId;


    public function __construct($auction, $value, $prefix, $tradeMessageId, $files = null, $images = null)
    {
        if ($auction->lots->where('number', $value['@attributes']['LotNumber'])->count() == 0) {
            $lot = new Lot();
            $lot->auction_id = $auction->id;
        } else {
            $lot = $auction->lots->where('number', $value['@attributes']['LotNumber'])->first();
        }
        $this->lot = $lot;
        $this->value = $value;
        $this->prefix = $prefix;
        $this->files = $files;
        $this->images = $images;
        $this->tradeMessageId = $tradeMessageId;
    }


    public function saveLot()
    {
        $lot = $this->lot;
        $prefix = $this->prefix;
        $value = $this->value;

        $lot->number = $value['@attributes']['LotNumber'];
        $lot->start_price = array_key_exists($prefix . 'StartPrice', $value) ? $value[$prefix . 'StartPrice'] : 0;
        if (array_key_exists($prefix . 'AdvancePercent', $value)) {
            $lot->deposit = gettype($value[$prefix . 'AdvancePercent']) == 'array' ? NULL : $value[$prefix . 'AdvancePercent'];
            $lot->is_deposit_rub = false;
        } elseif (array_key_exists('Advance', $value)) {
            $lot->deposit = gettype($value['Advance']) == 'array' ? NULL : $value['Advance'];
        }
        if (array_key_exists($prefix . 'StepPricePercent', $value)) {
            $lot->auction_step = gettype($value[$prefix . 'StepPricePercent']) == 'array' ? NULL : $value[$prefix . 'StepPricePercent'];
            $lot->is_step_rub = false;
        } elseif (array_key_exists($prefix . 'StepPrice', $value)) {
            $lot->auction_step = gettype($value[$prefix . 'StepPrice']) == 'array' ? NULL : $value[$prefix . 'StepPrice'];
        }
        $lot->status_id = 1;
        if (array_key_exists($prefix . 'Participants', $value)) {
            if (gettype($value[$prefix . 'Participants']) == 'array' && count($value[$prefix . 'Participants']) > 0) {
                if (gettype($value[$prefix . 'Participants'][$prefix . 'PaymentInfo']) == 'string') {
                    $lot->payment_info = stripslashes(preg_replace('/[\x00-\x1F\x7F]/u', ' ', $value[$prefix . 'Participants'][$prefix . 'PaymentInfo']));
                }
                if (gettype($value[$prefix . 'Participants'][$prefix . 'SaleAgreement']) == 'string') {
                    $lot->sale_agreement = stripslashes(preg_replace('/[\x00-\x1F\x7F]/u', ' ', $value[$prefix . 'Participants'][$prefix . 'SaleAgreement']));
                }
            }
        }
        if (array_key_exists($prefix . 'Participants', $value) && gettype($value[$prefix . 'Participants']) == 'string') {
            $lot->participants = stripslashes(preg_replace('/[\x00-\x1F\x7F]/u', ' ', $value[$prefix . 'Participants']));
        }
        if (array_key_exists($prefix . 'SaleAgreement', $value) && gettype($value[$prefix . 'SaleAgreement']) == 'string') {
            $lot->sale_agreement = stripslashes(preg_replace('/[\x00-\x1F\x7F]/u', ' ', $value[$prefix . 'SaleAgreement']));
        }
        if (array_key_exists($prefix . 'PaymentInfo', $value) && gettype($value[$prefix . 'PaymentInfo']) == 'string') {
            $lot->payment_info = stripslashes(preg_replace('/[\x00-\x1F\x7F]/u', ' ', $value[$prefix . 'PaymentInfo']));
        }

        if (array_key_exists($prefix . 'Concours', $value) && gettype($value[$prefix . 'Concours']) == 'string') {
            $lot->payment_info = $value[$prefix . 'Concours'];
        }
        $lot->created_at = Carbon::now()->setTimezone('Europe/Moscow');
        $lot->description = array_key_exists($prefix . 'TradeObjectHtml', $value) ? stripslashes(preg_replace('/[\x00-\x1F\x7F]/u', ' ', $value[$prefix . 'TradeObjectHtml'])) : NULL;
        $lot->save();
        $region = $lot->auction->debtor->region;
        if ($region && !$lot->regions->contains($region)) {
            $lot->regions()->attach($region, ['is_debtor_region' => true]);
        }
        if (!is_null($this->files)) {
            foreach ($this->files as $file) {
                $this->saveFiles($file, 'file');
            }
        }

        if (!is_null($this->images)) {
            foreach ($this->images as $image) {
                $this->saveFiles($image, 'image');
            }
        }

        if (gettype($value[$prefix . 'Classification'][$prefix . 'IDClass']) == 'array') {
            foreach ($value[$prefix . 'Classification'][$prefix . 'IDClass'] as $item) {
                $category = Category::where('code', $item)->first();
                if ($category) {
                    if (!$lot->categories()->where('title', $category->title)->exists()) {
                        $lot->categories()->attach($category);
                    }
                }
            }
        } else {
            $category = Category::where('code', $value[$prefix . 'Classification'][$prefix . 'IDClass'])->first();
            if($category) {
                if (!$lot->categories()->where('title', $category->title)->exists()) {
                    $lot->categories()->attach($category);
                }
            }
        }

        if ($lot->categories()->count() == 0) {
            $category = Category::where('code', '99')->first();
            $lot->categories()->attach($category);
        }
        if(!is_null($lot->description)){
            $descriptionExtracts = new DescriptionExtractsService();
            $descriptionExtracts->getDescriptionExtracts($lot, $lot->description);
        }
        if ($lot->auction->auctionType->title == 'PublicOffer' || $lot->auction->auctionType->title == 'ClosePublicOffer') {
            $priceReduction = new PriceReductionService();
            $priceReduction->savePriceReduction($lot->id, $lot->start_price, $lot->created_at, null, null, 0, 0, true);
            if (array_key_exists($prefix . 'PriceReduction', $value)) {
                $priceReduction->getPriceReduction($value[$prefix . 'PriceReduction'], $lot->id);
                $lot->price_reduction = $value[$prefix . 'PriceReduction'];
                $prices = $lot->showPriceReductions->pluck('price')->toArray();
                if (count($prices) > 0) {
                    $lot->min_price = min($prices);
                    $lot->save();
                }
            }
        }
        $lot->save();
        $id = $lot->auction->id_efrsb;
        if(!is_null($id)) {
            $soapWrapper = new SoapWrapper();
            $service = new SoapWrapperService($soapWrapper);
            $xml = $service->getMessageContent($id);
            $xml = Xml2Array::create($xml)->toArray();
            try {
                $text = null;
                $lots = [];
                if (array_key_exists('Auction', $xml['MessageInfo'])) {
                    $lots = $xml['MessageInfo']['Auction']['LotTable']['AuctionLot'];
                    $text = $xml['MessageInfo']['Auction']['Text'];
                } elseif (array_key_exists('ChangeAuction', $xml['MessageInfo'])) {
                    $lots = $xml['MessageInfo']['ChangeAuction']['LotTable']['AuctionLot'];
                    $text = $xml['MessageInfo']['ChangeAuction']['Text'];
                } elseif (array_key_exists('Auction2', $xml['MessageInfo'])) {
                    $lots = $xml['MessageInfo']['Auction2']['LotTable']['AuctionLot'];
                    $text = $xml['MessageInfo']['Auction2']['Text'];
                }
               $descriptionExtracts = new DescriptionExtractsService();
                if (array_key_exists('Order', $lots)) {
                    $auctionLot = $lots;
                    $descriptionExtracts->processDescriptionFromAuction($auctionLot, $lot, $text);
                } else {
                    foreach ($lots as $auctionLot) {
                        $descriptionExtracts->processDescriptionFromAuction($auctionLot, $lot, $text);
                    }
                }
            } catch (\Exception $e) {
                logger($e);
                logger($lot->id);
                logger($xml);
            }
        }

        return $lot;

    }

    public function saveFiles($file, $type)
    {
        $lot = $this->lot;
        if (!LotFile::where(['url' => json_encode($file), 'lot_id' => $lot->id, 'type' => $type])->exists()) {
            LotFile::create([
                'url' => json_encode($file),
                'type' => $type,
                'lot_id' => $lot->id,
                'trade_message_id' => $this->tradeMessageId
            ]);
        }
    }


}
