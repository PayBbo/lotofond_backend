<?php

namespace App\Http\Services\Parse;

use App\Jobs\RetryParseAuctionJob;
use App\Models\Bidder;
use App\Models\LotFile;
use App\Models\SroAu;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Midnite81\Xml2Array\Xml2Array;

class ParseAuctionService
{
    public function parseDataFromAuction($auction)
    {
        try {
            $soapWrapper = new SoapWrapper();
            $service = new SoapWrapperService($soapWrapper);
            $xml = $service->getMessageContent($auction->id_efrsb);
            $xml = Xml2Array::create($xml)->toArray();
            $text = null;
            $lots = [];
            $tmp_type = null;
            if (array_key_exists('Auction', $xml['MessageInfo'])) {
                $tmp_type = 'Auction';
            } elseif (array_key_exists('ChangeAuction', $xml['MessageInfo'])) {
                $tmp_type = 'ChangeAuction';
            } elseif (array_key_exists('Auction2', $xml['MessageInfo'])) {
                $tmp_type = 'Auction2';
            }
            if (!is_null($tmp_type)) {
                $lots = $xml['MessageInfo'][$tmp_type]['LotTable']['AuctionLot'];
                $text = $xml['MessageInfo'][$tmp_type]['Text'];
            }
            $descriptionExtracts = new DescriptionExtractsService();
            $lotOrders = [];
            if (array_key_exists('Order', $lots)) {
                $lotOrders = $descriptionExtracts->processDescriptionFromAuction([$lots], $text, $auction);
            } else {
                $lotOrders = $descriptionExtracts->processDescriptionFromAuction($lots, $text, $auction);
            }
            $this->parseBiddersAndFilesFromAuction($xml, $auction, $lotOrders);
        } catch (\Exception $e) {
            if (strpos($e->getMessage(), 'Access Denied') !== false) {
                dispatch((new RetryParseAuctionJob($auction))
                    ->delay(now()->setTimezone('Europe/Moscow')->addMinutes(5))
                    ->onQueue('parse'));
            } else {
                logger('ParseAuctionService. Error = ' . $e->getMessage() . ' ' . $e->getLine() . ' for auction = ' . $auction->id);
                logger($e);
            }
        }
    }

    private function parseBiddersAndFilesFromAuction($xml, $auction, $lotOrders)
    {
        $publisher = $xml['Publisher'];
        $bidder = Bidder::where('inn', $publisher['Inn'])->first();
        if ($bidder) {
            if (array_key_exists('Email', $publisher) && isset($publisher['Email'])) {
                $bidder->email = $publisher['Email'];
            }
            if (array_key_exists('Snils', $publisher) && isset($publisher['Snils'])) {
                $bidder->snils = $publisher['Snils'];
            }
            if (array_key_exists('Ogrn', $publisher) && isset($publisher['Ogrn'])) {
                $bidder->ogrn = $publisher['Ogrn'];
            }
            if (array_key_exists('Ogrnip', $publisher) && isset($publisher['Ogrnip'])) {
                $bidder->ogrnip = $publisher['Ogrnip'];
            }
            if (array_key_exists('CorrespondenceAddress', $publisher) && isset($publisher['CorrespondenceAddress'])) {
                $bidder->correspondence_address = $publisher['CorrespondenceAddress'];
            }
            if (array_key_exists('Sro', $publisher) && isset($publisher['Snils'])) {
                $sro = $bidder->sroAu;
                if (!$sro) {
                    $sro = new SroAu();
                    $bidder->sro_au_id = $sro->id;
                }
                if (array_key_exists('Name', $publisher['Sro']) && isset($publisher['Sro']['Name'])) {
                    $sro->name = $publisher['Sro']['Name'];
                }
                if (array_key_exists('Ogrn', $publisher['Sro']) && isset($publisher['Sro']['Ogrn'])) {
                    $sro->ogrn = $publisher['Sro']['Ogrn'];
                }
                if (array_key_exists('Inn', $publisher['Sro']) && isset($publisher['Sro']['Inn'])) {
                    $sro->inn = $publisher['Sro']['Inn'];
                }
                if (array_key_exists('Address', $publisher['Sro']) && isset($publisher['Sro']['Address'])) {
                    $sro->address = $publisher['Sro']['Address'];
                }
                $sro->save();
            }
            $bidder->save();
        }
        $lots = null;
        if (count($lotOrders) > 1) {
            $lots = $auction->lots->whereIn('number', $lotOrders);
        } else {
            if (count($lotOrders) == 1 && $auction->lots->count() == 1) {
                $lots = $auction->lots;
            }
        }
          if (!is_null($lots)) {
              $files = [];
              $parsedFiles = null;
              if (array_key_exists('MessageURLList', $xml) && array_key_exists('MessageURL', $xml['MessageURLList'])) {
                  $urls = $xml['MessageURLList']['MessageURL'];
                  if (array_key_exists('@attributes', $urls)) {
                      $files[] = ['filename' => $urls['@attributes']['URLName'], 'link' => $urls['@attributes']['URL']];
                  } else {
                      foreach ($urls as $url) {
                          $files[] = ['filename' => $url['@attributes']['URLName'], 'link' => $url['@attributes']['URL']];
                      }
                  }
                  $fileService = new FilesService();
                  $parsedFiles = $fileService->downloadFileByLink($files, $auction->id);
              }
              if (!is_null($parsedFiles)) {
                  foreach ($lots as $lot) {
                      if (count($parsedFiles['files']) > 0) {
                          foreach ($parsedFiles['files'] as $file) {
                              $this->saveFiles($file, 'file', $lot);
                          }
                      }
                      if (count($parsedFiles['images']) > 0) {
                          foreach ($parsedFiles['images'] as $image) {
                              $this->saveFiles($image, 'image', $lot);
                          }
                      }
                  }
              }
          }
    }

    private function saveFiles($file, $type, $lot)
    {
        if (!LotFile::where(['url' => json_encode($file), 'lot_id' => $lot->id, 'type' => $type])->exists()) {
            LotFile::create([
                'url' => json_encode($file),
                'type' => $type,
                'lot_id' => $lot->id
            ]);
        }
    }
}
