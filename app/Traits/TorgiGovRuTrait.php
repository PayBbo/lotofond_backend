<?php

namespace App\Traits;

use App\Http\Services\Parse\DescriptionExtractsService;
use App\Http\Services\Parse\FilesService;
use App\Jobs\ParseTorgiGovRu;
use App\Models\Auction;
use App\Models\AuctionType;
use App\Models\Bidder;
use App\Models\Category;
use App\Models\Lot;
use App\Models\LotFile;
use App\Models\Region;
use App\Models\Status;
use App\Models\TradePlace;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait TorgiGovRuTrait
{
    //<editor-fold desc="Настройки">
    /**
     * Стартовая настройка https://torgi.gov.ru
     */
    public function startSetting() {
        //добавляем коды к категориям лотов
        $this->setCategories();
        //добавляем виды торгов, которые отсутствуют
        $this->setBiddingTypes();
        //добавляем торговые площадки
        $this->setTradePlaces();
    }

    public function setCategories()
    {
        $categories = collect($this->callMethod('nsi/v1/CATEGORIES?actual=false'))->groupBy('parentCode')->all();
        $mainCategories = $categories[''];
        $result = [];
        foreach ($mainCategories as $category) {
            $category['subcategories'] = $categories[$category['code']];
            $category['subcategories_codes'] = collect($category['subcategories'])->pluck('code');
            if ($category['code'] == '22') {
                foreach ($category['subcategories_codes'] as $code) {
                    if ($code == '103') {
                        Category::firstOrCreate(['title' => 'airTransport', 'code' => $code, 'parent_id' => 59,
                            'label' => ['ru' => 'Авиатранспорт', 'en' => 'Air transport', 'zh_CN' => '航空运输']]);
                    }
                    if ($code == '16') {
                        Category::firstOrCreate(['title' => 'waterTransport', 'code' => $code, 'parent_id' => 59,
                            'label' => ['ru' => 'Водный транспорт', 'en' => 'Water transport', 'zh_CN' => '水上运输']]);
                    }
                    if ($code == '101') {
                        Category::firstOrCreate(['title' => 'specialEquipment', 'code' => '0106012', 'parent_id' => 59,
                            'label' => ['ru' => 'Спецтехника', 'en' => 'Special equipment', 'zh_CN' => '特殊设备']]);
                    }
                    if ($code == '100') {
                        Category::firstOrCreate(['title' => 'mototechnics', 'code' => '100000', 'parent_id' => 59,
                            'label' => ['ru' => 'Мототехника', 'en' => 'Mototechnics', 'zh_CN' => '机动车辆']]);
                        Category::firstOrCreate(['title' => 'freightTransport', 'code' => '100002', 'parent_id' => 59,
                            'label' => ['ru' => 'Грузовой транспорт', 'en' => 'Freight transport', 'zh_CN' => '货物运输']]);
                        Category::firstOrCreate(['title' => 'passengerTransport', 'code' => '100001', 'parent_id' => 59,
                            'label' => ['ru' => 'Легковой транспорт', 'en' => 'Passenger transport', 'zh_CN' => '客运服务']]);
                    }
                    if ($code == '104' || $code == '110' || $code == '106' || $code == '31') {
                        Category::firstOrCreate(['title' => 'other', 'code' => $code, 'parent_id' => NULL,
                            'label' => ['ru' => 'Прочее', 'en' => 'Other', 'zh_CN' => '其他']]);
                    }

                }
            }
            if ($category['code'] == '7') {
                foreach ($category['subcategories_codes'] as $code) {
                    if ($code == '9') {
                        Category::firstOrCreate(['title' => 'residentialProperty', 'code' => $code, 'parent_id' => 1,
                            'label' => ['ru' => 'Недвижимость жилая', 'en' => 'Residential property', 'zh_CN' => '住宅地产']]);
                    } else {
                        Category::firstOrCreate(['title' => 'commercialRealEstate', 'code' => $code, 'parent_id' => 1,
                            'label' => ['ru' => 'Недвижимость коммерческая', 'en' => 'Commercial Estate', 'zh_CN' => '商业地产']]);
                    }

                }
            }
            if ($category['code'] == '5') {
                foreach ($category['subcategories_codes'] as $code) {
                    Category::firstOrCreate(['title' => 'obligations', 'code' => $code, 'parent_id' => NULL,
                        'label' => ['ru' => 'Ценные бумаги', 'en' => 'Obligations', 'zh_CN' => '证券']]);
                }
            }
            if ($category['code'] == '13' || $category['code'] == '23'
                || $category['code'] == '17' || $category['code'] == '6' || $category['code'] == '900') {
                foreach ($category['subcategories_codes'] as $code) {
                    Category::firstOrCreate(['title' => 'other', 'code' => $code, 'parent_id' => NULL,
                        'label' => ['ru' => 'Прочее', 'en' => 'Other', 'zh_CN' => '其他']]);
                }
            }
            if ($category['code'] == '2') {
                foreach ($category['subcategories_codes'] as $code) {
                    Category::firstOrCreate(['title' => 'land', 'code' => $code, 'parent_id' => 1,
                        'label' => ['ru' => 'Земельные участки', 'en' => 'Land', 'zh_CN' => '地皮']]);
                }
            }
            $result[] = $category;
        }
        return $result;
    }

    public function setBiddingTypes()
    {
        /*
        * [
   {
       "code": "EA",
       "name": "Электронный аукцион"
   },
   {
       "code": "PP",
       "name": "Публичное предложение"
   },
   {
       "code": "BOC",
       "name": "Продажа без объявления цены"
   },
   {
       "code": "EK",
       "name": "Электронный конкурс"
   },
   {
       "code": "SA",
       "name": "Специализированный аукцион"
   },
   {
       "code": "IPS",
       "name": "Сообщение о предоставлении (реализации)"
   },
   {
       "code": "SMP",
       "name": "Продажа по минимально допустимой цене"
   },
   {
       "code": "PrP",
       "name": "Прямая продажа"
   },
   {
       "code": "PA",
       "name": "Аукцион"
   },
   {
       "code": "BC",
       "name": "Электронный аукцион за долю"
   },
   {
       "code": "PK",
       "name": "Конкурс"
   },
   {
       "code": "IO",
       "name": "Предложение о заключении концессионного соглашения"
   },
   {
       "code": "OIP",
       "name": " Отбор инвестиционных проектов"
   },
   {
       "code": "PPZ",
       "name": "Публичное предложение (ЗК РФ) "
   },
   {
       "code": "GHP",
       "name": "Решение о реализации проекта ГЧП, проекта МЧП"
   },
   {
       "code": "BCU",
       "name": "Продажа без объявления цены  (цессия)"
   },
   {
       "code": "PPU",
       "name": "Публичное предложение (цессия)"
   }
]*/
        $types = $this->callMethod('nsi/v1/BIDD_TYPE');
        $biddingForms = [];
        foreach ($types as $type) {
            $biddingForms = array_merge($biddingForms, $type['biddingForms']);
        }
        $forms = collect($biddingForms)->unique()->values();
        foreach ($forms as $form) {
            $auctionType = AuctionType::where('title', $form['code'])->orWhere('description', $form['name'])->first();
            if(!$auctionType) {
                AuctionType::create([
                    'title' => $form['code'],
                    'description' => $form['name'],
                ]);
            }
        }
        return AuctionType::all();
    }

    public function setTradePlaces() {
        $places = $this->getElectronicPlatforms();
        foreach ($places as $place) {
            $tradePlace = TradePlace::where('code', $place['code'])->orWhere('site', 'like', '%' . $place['site'] . '%')->first();
            if (!$tradePlace) {
                $tradePlace = TradePlace::firstOrCreate([
                    'code' => $place['code'],
                    'site' => $place['site'],
                    'name' => $place['shortName'],
                    'owner_name' => $place['name']
                ]);
            }
            else {
                $tradePlace->code = $place['code'];
                $tradePlace->save();
            }
        }
    }
    //</editor-fold>

    //<editor-fold desc="Команды">
    /**
     * Последние извещения
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function getLastNotices($limit=0, $count_statuses=false)
    {
        $result = [];
        $notices = [];

        try {
            $notices = $this->getNotices();
        }
        catch (\Exception $exception) {
            logger('FAILED getNotices, RESTART');
            dispatch((new ParseTorgiGovRu())
                ->delay(now()->setTimezone('Europe/Moscow')->addMinutes(5))
                ->onQueue('parseTorgi'));
        }

        $i = 0;
        $statuses = ['noticeCancel', 'noticeStop', 'noticeResumption', 'noticeAnnulment'];

        foreach ($notices as $notice) {
            $item = $this->callMethod('', [], $notice['href']);
            if ($notice['documentType'] === 'notice') {
                $result[] = $this->parseAuction($item, $notice['documentType'], $notice['subjectRightHolderCode']);
                $i++;
            }
            else {
                $auction = Auction::where('trade_id', $notice['regNum'])->first();
                if ($auction) {
                    $files = $this->parseFiles($item);
                    $lots = Lot::where('auction_id', $auction->id)->get();
                    foreach ($lots as $lot) {
                        $this->storeFiles($files, $auction->id, $lot->id);
                        if (in_array($notice['documentType'], $statuses)) {
                            $lot->status_id = $this->parseStatus($notice['documentType']);
                            $lot->save();
                        }
                    }
                }
                if ($count_statuses) {
                    $i++;
                }
            }
            if ($limit > 0 && $i === $limit) {
                logger('limit break ' . $limit);
                break;
            }
            logger('$i = ' . $i);
        }

        return $result;
    }

    public function getNotices() {
        $response = $this->callMethod('opendata/7710568760-notice/meta.json');
        if (isset($response['data']) && count($response['data'])) {
            $last = end($response['data']);
            if (isset($last['source'])) {
                $notices = $this->callMethod('', [], $last['source']);
                if (isset($notices['listObjects'])) {
                    return $notices['listObjects'];
                }
            }
        }
        return [];
    }

    public function getCurrentNotices($from = null, $to = null) {
        $notices = [];
        try {
            $notices = $this->searchAuctions($from, $to);
        }
        catch (\Exception $exception){
            logger('FAILED getNotices, RESTART');
            dispatch((new ParseTorgiGovRu('current', $from, $to))
                ->delay(now()->setTimezone('Europe/Moscow')->addMinutes(5))
                ->onQueue('parseTorgi'));
        }
        foreach ($notices as $notice) {
            if(isset($notice['noticeNumber'])) {
                 $fullNotice = $this->getAuction($notice['noticeNumber']);
                 if($fullNotice) {
                     $this->parseAuction($fullNotice);
                 }
            }
        }
    }
    //</editor-fold>

    //<editor-fold desc="API">
    //Получение аукциона/извещения
    //https://torgi.gov.ru/new/api/public/notices/noticeNumber/21000000050000000595

    //Поиск аукционов/извещений
    //https://torgi.gov.ru/new/api/public/notices/search?byFirstVersion=true&withFacets=true&size=10&sort=firstVersionPublicationDate,desc

    //Получение лота
    //https://torgi.gov.ru/new/api/public/lotcards/21000000050000000595_1

    //Поиск лотов
    //https://torgi.gov.ru/new/api/public/lotcards/search?pubFrom=2024-07-28&pubTo=2024-07-28&matchPhrase=false&byFirstVersion=true&withFacets=true&size=10&sort=firstVersionPublicationDate,asc

    //Получение файлов
    //https://torgi.gov.ru/new/file-store/v1/66a1fa28c7b014348efd4269?disposition=inline&resize=600x600!

    public function searchAuctions($from = null, $to = null, $page=0)
    {
        if(!$from && !$to) {
            $date = Carbon::now()->format('Y-m-d');
            $from = $date;
            $to = $date;
        }

        $query = [
            'byFirstVersion' => true,
            'withFacets' => true,
            'size' => 100,
            'sort' => 'firstVersionPublicationDate,desc',
            'pubFrom' => $from,
            'pubTo'=> $to,
            'page' => $page
        ];
        $result = [];
        $response = $this->callMethod('api/public/notices/search', $query);
        if (isset($response['content']) && count($response['content'])) {
            $result = array_merge($result, $response['content']);
        }
        //todo: check recursion function, that it take all pages of search to result
        if(isset($response['last']) && $response['last'] === false) {
            $result = array_merge($result, $this->searchAuctions($from, $to, $page+1));
        }
        return $result;
    }

    public function getAuction($noticeId = null)
    {
        return $this->callMethod('api/public/notices/noticeNumber/' . $noticeId);
    }

    public function getAuctions($from = null, $to = null)
    {
        if (!$from) {
            $from = Carbon::yesterday()->format('Ymd');
            $to = Carbon::now()->format('Ymd');
        }
//        https://torgi.gov.ru/new/opendata/7710568760-notice/data-20240810T0000-20240811T0000-structure-20240401.json
        $response = $this->callMethod('opendata/7710568760-notice/data-' . $from . 'T0000-' . $to . 'T0000-structure-20240401.json');
//        $response = $this->callMethod('opendata/7710568760-notice/meta.json');
//        https://torgi.gov.ru/new/opendata/7710568760-notice/meta.json
        return $response;
    }

    public function searchLots($from = null, $to = null)
    {
        $query = [
            'matchPhrase' => false,
            'byFirstVersion' => true,
            'withFacets' => true,
            'size' => 10,
            'sort' => 'firstVersionPublicationDate,asc',
            'pubFrom' => $from,
            'pubTo' => $to,
        ];
        $response = $this->callMethod('api/public/lotcards/search', $query);
        return $response;
    }

    public function getLot($lotId = null)
    {
        $response = $this->callMethod('api/public/lotcards/' . $lotId);
        return $response;
    }

    public function getFile($fileId = null, $raw = true)
    {
        $query = [
//            'disposition' => 'inline',
//            'resize' => '600x600!',
        ];
        return $this->callMethod('file-store/v1/' . $fileId, $query, null, $raw);
    }
    //</editor-fold>

    //<editor-fold desc="Парсинг">
    public function parseAuction($parse, $documentType = 'notice', $subjectRightHolderCode = null)
    {
        try {
            if (isset($parse['exportObject'])) {
                $parse = $parse['exportObject']['structuredObject'][$documentType];
                if (isset($parse['biddConditions'])) {
                    $parse = array_merge($parse, $parse['biddConditions']);
                    logger('biddConditions merge');
                }
                if (isset($parse['commonInfo'])) {
                    $parse = array_merge($parse, $parse['commonInfo']);
                    logger('commonInfo merge');
                }
            }
            if ($parse) {
                DB::transaction(function () use($parse, $documentType, $subjectRightHolderCode) {
                    logger('start -----------------------' . $parse['noticeNumber']);
                    $companyTradeOrganizerId = null;
                    $debtorId = null;
                    //организатор
                    $bidderOrg = isset($parse['bidderOrg']) ? $parse['bidderOrg'] : null;
                    if ($bidderOrg) {
                        if (isset($bidderOrg['orgInfo']) && isset($bidderOrg['contactInfo'])) {
                            $bidderOrg = array_merge($bidderOrg['orgInfo'], $bidderOrg['contactInfo']);
                        }
                        $bidder = $this->parseBidder($bidderOrg, 'organizer');
                        if ($bidder) {
                            $companyTradeOrganizerId = $bidder->id;
                        }
                    }

                    //правообладатель
//                    $rightHolderOrg = isset($parse['rightHolderInfo']) ? $parse['rightHolderInfo']['rightHolderOrg'] : $parse['rightHolderOrg'];
//                    if ($rightHolderOrg) {
//                        $rightHolder = $this->parseBidder($rightHolderOrg, 'debtor', $subjectRightHolderCode);
//                        if ($rightHolder) {
//                            $debtorId = $rightHolder->id;
//                        }
//                    }

                    $auction = Auction::firstOrCreate(
                        [
                            'guid' => isset($parse['rootId']) ? $parse['rootId'] : $parse['id'],
                            'trade_id' => $parse['noticeNumber'],
                        ],
                        [
                            'trade_id' => $parse['noticeNumber'],
                            'publish_date' => $parse['publishDate'],
                            'event_start_date' => isset($parse['auctionStartDate']) ? $parse['auctionStartDate']
                                : (isset($parse['startDate']) ? $parse['startDate'] : null),
//            'event_end_date' => $parse['biddReviewDate'],
                            'application_start_date' => $parse['biddStartTime'],
                            'application_end_date' => $parse['biddEndTime'],
                            'source_id' => 2,
//            'result_date' => $parse['biddReviewDate'],
                            'debtor_id' => $debtorId,
                            'company_trade_organizer_id' => $companyTradeOrganizerId,
                            'auction_type_id' => $this->parseBiddingForm($parse['biddForm']['code'], $parse['biddForm']['name']),
                            'price_form' => 'open'
                        ]
                    );

                    logger('etp ');
                    $etp = isset($parse['etpCode']) ? $parse['etpCode'] : (isset($parse['etp']['code']) ? $parse['etp']['code'] : null);
                    if ($etp) {
                        $tradePlace = TradePlace::where('code', $etp)->first();
                        if (!$tradePlace) {
                            $platforms = $this->getElectronicPlatforms();
                            if ($platforms) {
                                $platform = collect($platforms)->where('code', $etp)->first();
                                if ($platform) {
                                    $tradePlace = TradePlace::where('site', 'like', '%' . $platform['site'] . '%')->first();
                                }
                            }
                        }
                        if ($tradePlace) {
                            $auction->trade_place_id = $tradePlace->id;
                        }
                    }

                    $auction->save();
                    logger('parseAuction parseFiles');
                    $files = $this->parseFiles($parse);
                    if (isset($parse['lots'])) {
                        foreach ($parse['lots'] as $lot) {
                            $this->parseLot($lot, $auction->id, $parse['noticeNumber'], $files);
                        }
                    }
                    logger(' end au-------------------- ' . $parse['noticeNumber']);
                    return $auction;
                });
            }
            return null;
        } catch (\Exception $e) {
            logger('error = ' . $e->getMessage());
            return $e->getMessage();
        }
    }

    public function parseBidder($parse, $type, $regionCode = null)
    {
        logger('regionCode '.$regionCode);
        if ($parse) {
            $regionId = null;
            if ($regionCode) {
                $region =  $region = Region::where('numbers', 'LIKE', '%' . $regionCode . '%')->first();
                if ($region) {
                    $regionId = $region->id;
                }
            }

            $bidder = Bidder::firstOrCreate(
                [
                    'inn' => isset($parse["inn"]) ? $parse["inn"] : $parse["INN"],
                ],
                [
                    'name' => $parse["name"],
                    'short_name' => isset($parse["shortName"]) ? $parse["shortName"] : null,
                    'ogrn' => isset($parse["ogrn"]) ? $parse["ogrn"] : $parse["OGRN"],
//                'ogrnip' => $bidderOrg[""],
//                'snils' => isset()$bidderOrg[""],
                    'type' => isset($parse['orgType']) ? ($parse['orgType'] === 'AGENCY' ? 'company' : 'person') : 'company',
                    'address' => isset($parse['legalAddress']) ? $parse['legalAddress'] : null,
//                'middle_name' => $bidderOrg[""],
//                'last_name' => $bidderOrg[""],
                    'region_id' => $regionId,
                'debtor_category_id' => 8,
                    'reg_num' => isset($parse['code']) ? $parse['code'] : null,
                'correspondence_address' => isset($parse['actualAddress']) ? $parse['actualAddress'] : null,
//                'sro_au_id' => $bidderOrg[""],
//                'reg_date' => $bidderOrg[""],
//                'bankrupt_id' => $bidderOrg[""]
                ]
            );
            if ($bidder->wasRecentlyCreated) {
                if(isset($parse['tel'])) {
                    $bidder->phone = $parse['tel'];
                }
                if(isset($parse['email'])) {
                    $bidder->email = $parse['email'];
                }
                $bidder->save();
            }
            $bidder_type = Type::where('title', $type)->first();
            if (!$bidder->types->contains($bidder_type)) {
                $bidder->types()->attach($bidder_type);
            }

            return $bidder;
        }
        return null;
    }

    public function parseBiddingForm($code, $name) {
        logger('parseBiddingForm');
        $auctionType = AuctionType::where('title', $code)->orWhere('description',$name)->first();
        return $auctionType ? $auctionType->id : 1;
    }

    public function parseLot($parse, $auctionId, $auctionNumber, $auctionFiles = [])
    {
        logger('parseLot');
        $lot = Lot::firstOrCreate(
            [
                'guid' => isset($parse['id']) ? $parse['id'] : $auctionNumber . '_' . $parse['lotNumber'],
                'auction_id' => $auctionId,
            ],
            [
                'number' => isset($parse['lotNumber']) ? $parse['lotNumber'] : 1,
                'start_price' => isset($parse['priceMin']) ? $parse['priceMin'] : null,
                'min_price' => isset($parse['priceMin']) ? $parse['priceMin'] : null,
                'auction_step' => isset($parse['priceStep']) ? $parse['priceStep'] : null,
                'is_step_rub' => true,
                'deposit' => isset($parse['deposit']) ? $parse['deposit'] : null,
                'is_deposit_rub' => true,
                'description' => isset($parse['lotDescription']) ? $parse['lotDescription'] : null,
//                'processed_description'=> $parse[''],
                'status_id' => $this->parseStatus($parse['lotStatus']),
                'created_at' =>Carbon::now()->setTimezone('Europe/Moscow')
//                'price_reduction'=> $parse['']
            ]
        );

        if ($lot->wasRecentlyCreated) {
            logger('parseLot wasRecentlyCreated');
            if (isset($parse['category']) && isset($parse['category']['code'])) {
                logger('category code = '.$parse['category']['code']);
                $category = Category::where('code', $parse['category']['code'])->first();
                if ($category) {
                    if (!$lot->categories()->where('title', $category->title)->exists()) {
                        $lot->categories()->attach($category);
                    }
                }
            }
            logger('parseLot categories');
            if ($lot->categories()->count() == 0) {
                $category = Category::where('code', '99')->first();
                $lot->categories()->attach($category);
            }
            $torgiCategory = Category::where('code', 'torgi')->first();
            if($torgiCategory) {
                $lot->categories()->attach($torgiCategory);
            }

            logger('parseLot getDescriptionExtracts');
            $descriptionExtracts = new DescriptionExtractsService();
            $descriptionExtracts->getDescriptionExtracts($lot, $lot->description);
            logger('parseLot parseFiles');
            if (isset($parse['docs']) && count($parse['docs'])) {
                $parse['attachments'] = $parse['docs'];
            }

            if(isset($parse['subjectRFCode'])) {
                $region = Region::where('numbers', 'LIKE', '%' . $parse['subjectRFCode'] . '%')->first();
                if ($region) {
                    if (!$lot->objectRegions->contains($region)) {
                        $lot->regions()->attach($region, ['is_debtor_region' => false]);
                    }
                }
            }

//            $priceReduction = new PriceReductionService();
//            $priceReduction->savePriceReduction($lot->id, $lot->start_price, $lot->created_at, null, null, 0, $lot->deposit, true);
//
            logger('parseLot parseFiles parse');
            $files = array_merge($this->parseFiles($parse), $auctionFiles);
            try {
                $this->storeFiles($files, $auctionId, $lot->id);
            }
            catch (\Exception $exception) {
            }

        }
    }

    public function parseStatus($code) {
        logger('parseStatus '.$code);
//            ['code' => 'applicationSessionStarted', 'value' => 'Начат прием заявок'],
//            ['code' => 'applicationSessionEnd', 'value' => 'Приём заявок закончен'],
//            ['code' => 'biddingInProcess', 'value' => 'Идут торги'],
//            ['code' => 'finished', 'value' => 'Торги завершены'],
//            ['code' => 'biddingFail', 'value' => 'Торги не состоялись'],
//                            //clarifications - Разъяснение;

        $statuses = [
            'notice' => 'biddingDeclared',
            'noticeCancel' => 'biddingCanceled',
            'noticeStop' => 'biddingPaused',
            'noticeResumption' => 'biddingResumed',
            'noticeAnnulment' => 'annul',
            'CANCELED' => 'biddingCanceled',
            'PUBLISHED' => 'biddingDeclared',
            'FAILED' => 'biddingFail',
            'APPLICATIONS_SUBMISSION' => 'applicationSessionStarted',
            'DETERMINING_WINNER' => 'applicationSessionEnd',
            'SUCCEED' => 'finished',
        ];

        $status = Status::where('code', $statuses[$code])->first();

        return $status ? $status->id : 1;
    }

    public function parseStatusName($code) {
        $statuses = [
            'notice' => 'biddingDeclared',
            'noticeCancel' => 'biddingCanceled',
            'noticeStop' => 'biddingPaused',
            'noticeResumption' => 'biddingResumed',
            'noticeAnnulment' => 'annul',
            'CANCELED' => 'biddingCanceled',
            'PUBLISHED' => 'biddingDeclared',
            'FAILED' => 'biddingFail',
            'APPLICATIONS_SUBMISSION' => 'applicationSessionStarted',
            'DETERMINING_WINNER' => 'applicationSessionEnd',
            'SUCCEED' => 'finished',
        ];

        return isset($statuses[$code]) ? $statuses[$code] : null;
    }

    public function parseFiles($parse)
    {
        logger('function parseFiles -------------------------------------------- Start');
        $files = [];
        $attachments = isset($parse['attachments']) ? $parse['attachments'] : [];
        if (isset($parse['docs']) && count($parse['docs'])) {
            $attachments = array_merge($attachments, $parse['docs']);
        }

        if (isset($parse['imageIds']) && count($parse['imageIds']) && is_array($parse['imageIds'][0])) {
            $attachments = array_merge($attachments, $parse['imageIds']);
        }

        if ($attachments) {
            foreach ($attachments as $attachment) {
                try {
                    if(isset($attachment['id'])) {
                        $content = $this->getFile($attachment['id'], true);
                        if ($content) {
                            $files[] = [
                                'filename' => $attachment['name'],
                                'link' => 'https://torgi.gov.ru/new/file-store/v1/' . $attachment['id'],
                                'content' => $content,
                                'guid' => $attachment['id']
                            ];
                        }
                    }
                    else {
                        logger('parseFiles no attachment ID ');
                    }
                }
                catch (\Exception $exception) {
                    logger('parseLot downloadFile '.(isset($attachment['id']) ? $attachment['id'] : ''));
                    logger('parseLot downloadFile error = '.$exception->getMessage());
                }

            }
        }

        logger('function parseFiles -------------------------------------------- End');
        return $files;
    }

    public function storeFiles($files=[], $auctionId=null, $lotId=null) {
        $fileService = new FilesService();
        $parsedFiles = $fileService->downloadFileByLink($files, $auctionId, true);
        if (!is_null($parsedFiles)) {
            if (count($parsedFiles['files']) > 0) {
                foreach ($parsedFiles['files'] as $file) {
                    $this->saveFile($file, 'file', $lotId);
                }
            }
            if (count($parsedFiles['images']) > 0) {
                foreach ($parsedFiles['images'] as $image) {
                    $this->saveFile($image, 'image', $lotId);
                }
            }
        }
    }
    //</editor-fold>

    private function saveFile($file, $type, $lotId = null)
    {
        if (!LotFile::where(['url' => json_encode($file), 'lot_id' => $lotId, 'type' => $type])->exists()) {
            LotFile::firstOrCreate([
                'url' => json_encode($file),
                'type' => $type,
                'lot_id' => $lotId
            ]);
        }
    }

    //<editor-fold desc="Справочники">
    public function getElectronicPlatforms()
    {
        return $this->callMethod('nsi/v1/ELECTRONIC_PLATFORM');
    }

    public function getRegions()
    {
        return $this->callMethod('nsi/v1/SUBJECT');
    }

    public function getSpecifications()
    {
        return $this->callMethod('nsi/v1/SPECIFICATIONS');
    }

    public function getUnits()
    {
        //меры измерения
        return $this->callMethod('nsi/v1/OKEI?actual=true');
    }

    public function getCategories()
    {
        return $this->callMethod('nsi/v1/CATEGORIES?actual=false');
    }

    public function getBiddingTypes()
    {
        return $this->callMethod('nsi/v1/BIDD_TYPE');
    }
    //</editor-fold>

    public function callMethod($url = '', $request = [], $mainUrl = 'https://torgi.gov.ru/new/', $raw = false)
    {
        if (!$mainUrl) {
            $mainUrl = 'https://torgi.gov.ru/new/';
        }
        $client = new \GuzzleHttp\Client();

        $responseFromApi = $client->request('GET', $mainUrl . $url, [
            'headers' => ['Content-Type' => 'application/javascript'],
            'query' => $request
        ]);

        $content = $responseFromApi->getBody()->getContents();

        $response = $raw ? $content : \GuzzleHttp\json_decode($content, true);

        return $response;
    }
}
