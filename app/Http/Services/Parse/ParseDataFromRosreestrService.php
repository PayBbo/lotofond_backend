<?php

namespace App\Http\Services\Parse;

use App\Models\Lot;
use App\Models\LotParam;
use App\Models\Param;
use App\Models\Region;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class ParseDataFromRosreestrService
{
    protected $cadastralNumber;
    protected $lotId;
    protected $categories;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($cadastralNumber, $lotId, $categories=null)
    {
        $this->cadastralNumber = $cadastralNumber;
        $this->lotId = $lotId;
        $this->categories = $categories;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $cadastralNumber = preg_replace("/::/", ':0:', preg_replace("/(^0+)|(?<=:)(0*)/", '', $this->cadastralNumber));
            $lotParam = LotParam::where(['value'=> $this->cadastralNumber, 'lot_id' => $this->lotId])->first();
            if ($lotParam) {
                $lot = Lot::find($lotParam->lot_id);
                $mainLotParam = LotParam::find($lotParam->parent_id);

                $client = new \GuzzleHttp\Client(['verify' => false]);

                $res = null;
                $pkkType = null;
                //если подходящие категории, то ищем информацию по карте
                if($this->categories && count($this->categories))
                {
                    if($this->categories->whereIn('title', ['agriculturalComplex', 'land', 'agriculturaProperty', 'other'])->first())
                    {
                        $pkkType = 1;
                    }
                    if($this->categories->whereIn('title', ['residentialProperty', 'commercialRealEstate', 'buildingsAndConstructions', 'realEstate'])->first())
                    {
                        $pkkType = 5;
                    }
                    if($pkkType) {
                        //данные по публичной карте
                        logger('данные по публичной карте ');
                        $res = $this->getPkkObject($client, $cadastralNumber, $pkkType, $lotParam, $lot, $mainLotParam);
                    }
                }
                //если карта ничего не вернула
                if(!$res) {
                    //старое апи и данные, но что есть, то есть
                    $res = $this->getFirObject($client, $cadastralNumber, $lotParam, $lot, $mainLotParam);
                    if(!$res) {
                        //более новое апи и данные
                        $res = $this->getFirLiteObject($client, $cadastralNumber, $lotParam, $lot, $mainLotParam);
                    }
                }

                if(!$mainLotParam&&isset($res['mainLotParam'])) {
                    $mainLotParam = $res['mainLotParam'];
                }

                //если есть адрес, то определяем координаты через Яндекс
                if($res && isset($res['address']) && $mainLotParam) {
                    $yandexData = $this->getCoordinatesFromYandex($client, $res['address'], $lot, $mainLotParam);
                    $res['yandexData'] = $yandexData;
                }
                return $res;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getFirObject($client, $cadastralNumber, $lotParam, $lot, $mainLotParam)
    {
        $res = $client->get('https://rosreestr.ru/api/online/fir_object/' . $cadastralNumber);
        if ($res->getStatusCode() == 200) {
            $data = json_decode($res->getBody(), true);
            if(isset($data['objectData'])) {
                $response = $data;
                $objectAddress = $data['objectData']['objectAddress']['mergedAddress'];
                $response['address'] = $objectAddress;
                $objectRegion = $data['objectData']['objectAddress']['region'];
                $region = Region::where('numbers', 'LIKE', '%' . $objectRegion . '%')->first();
                if ($region) {
                    $objectAddress = $region->title . ', ' . $objectAddress;
                    if (!$lot->objectRegions->contains($region)) {
                        $lot->regions()->attach($region, ['is_debtor_region' => false]);
                    }
                }
                $objectName = 'Участок';
                $type = 'other';
                if ($data['type'] == 'parcel') {
                    $flag = $data['parcelData']['oksFlag'];
                    if ($flag == 1) {
                        switch ($data['parcelData']['oksType']) {
                            case 'building':
                            {
                                $objectName = 'Здание';
                                $type = 'building';
                                break;
                            }
                            case 'construction':
                            {
                                $objectName = 'Сооружение';
                                $type = 'construction';
                                break;
                            }
                            case 'flat':
                            {
                                $objectName = 'Квартира';
                                $type = 'flat';
                                break;
                            }
                        }
                    } else {
                        $objectName = 'Земельный участок';
                        $type = 'landPlot';
                    }
                }
                elseif ($data['type'] == 'premises') {
                    $objectName = 'Помещение';
                    $type = 'premise';
                }

                if (!$mainLotParam) {
                    $mainLotParam = LotParam::firstOrCreate([
                        'param_id' => 7,
                        'value' => stripslashes(preg_replace('/[\x00-\x1F\x7F]/u', ' ', $objectName . ' по адресу ' . $objectAddress)),
                        'lot_id' => $lot->id,
                        'type' => $type
                    ]);
                    $lotParam->parent_id = $mainLotParam->id;
                    $lotParam->save();
                    $response['mainLotParam'] = $mainLotParam;
                }

                if (isset($data['parcelData']['cadCost']) && $data['parcelData']['cadCost'] != null) {
                    $objectCadastralPrice = $data['parcelData']['cadCost'];
                    if (!$lot->params()->where(['param_id' => 1, 'value' => $objectCadastralPrice, 'parent_id' => $mainLotParam->id])->exists()) {
                        $lot->params()->attach(1, ['value' => $objectCadastralPrice, 'parent_id' => $mainLotParam->id]);
                    }
                }
                if (isset($data['parcelData']['areaValue']) && $data['parcelData']['areaValue'] != null) {
                    $objectCadatralArea = $data['parcelData']['areaValue'];
                    if ($objectCadatralArea) {
                        if (!$lot->params()->where(['param_id' => 2, 'value' => $objectCadatralArea, 'parent_id' => $mainLotParam->id])->exists()) {
                            $lot->params()->attach(2, ['value' => $objectCadatralArea, 'parent_id' => $mainLotParam->id]);
                        }
                    }
                }
                if (isset($data['parcelData']['oksFloors']) && $data['parcelData']['oksFloors'] != null) {
                    $floorsCount = $data['parcelData']['oksFloors'];
                    if ($floorsCount) {
                        if (!$lot->params()->where(['param_id' => 8, 'value' => $floorsCount, 'parent_id' => $mainLotParam->id])->exists()) {
                            $lot->params()->attach(8, ['value' => $floorsCount, 'parent_id' => $mainLotParam->id]);
                        }
                    }
                }
                if (isset($data['parcelData']['oksYearBuilt']) && $data['parcelData']['oksYearBuilt'] != null) {
                    $yearBuilt = $data['parcelData']['oksYearBuilt'];
                    if ($yearBuilt) {
                        if (!$lot->params()->where(['param_id' => 9, 'value' => $yearBuilt, 'parent_id' => $mainLotParam->id])->exists()) {
                            $lot->params()->attach(9, ['value' => $yearBuilt, 'parent_id' => $mainLotParam->id]);
                        }
                    }
                }
                if (isset($data['parcelData']['oksElementsConstructStr']) && $data['parcelData']['oksElementsConstructStr'] != null) {
                    $elementConstract = $data['parcelData']['oksElementsConstructStr'];
                    if ($elementConstract) {
                        if (!$lot->params()->where(['param_id' => 10, 'value' => $elementConstract, 'parent_id' => $mainLotParam->id])->exists()) {
                            $lot->params()->attach(10, ['value' => $elementConstract, 'parent_id' => $mainLotParam->id]);
                        }
                    }
                }

                return $response;
            }
        }
        return null;
    }

    public function getFirLiteObject($client, $cadastralNumber, $lotParam, $lot, $mainLotParam) {
        $res = $client->get('https://rosreestr.gov.ru/fir_lite_rest/api/gkn/fir_lite_object/' . $cadastralNumber);
        if ($res->getStatusCode() == 200) {
            $data = json_decode($res->getBody(), true);
            if (isset($data['objectData'])) {
                $response = $data;
                $objectData = $data['objectData'];

                $objectAddress = $data['objectData']['address']['mergedAddress'];
                $response['address'] = $objectAddress;
                $objectRegion = $data['objectData']['address']['region'];
                $region = Region::where('numbers', 'LIKE', '%' . $objectRegion . '%')->first();
                if ($region) {
                    $objectAddress = $region->title . ', ' . $objectAddress;
                    if (!$lot->objectRegions->contains($region)) {
                        $lot->regions()->attach($region, ['is_debtor_region' => false]);
                    }
                }

//                    $names = ['parcel' => 'Земельный участок', 'flat'=> '', 'building'=> '', 'construction'=> '', 'premises'=>''];
                $objectName = isset($objectData['objectDesc']) && $objectData['objectDesc'] ? $objectData['objectDesc']
                    : (isset($objectData['name']) ? $objectData['name'] : '');
                $type = isset($objectData['objectType']) && $objectData['objectType'] ? $objectData['objectType']
                    : (isset($data['type']) ? $data['type'] : 'other');
                $objectTypeName = $type;
                if ($type === 'parcel') {
                    $type = 'landPlot';
                    $objectTypeName = 'parcelData';
                }
                if ($type == 'premises') {
                    $type = 'premise';
                }

                if (!$mainLotParam) {
                    $mainLotParam = LotParam::firstOrCreate([
                        'param_id' => 7,
                        'value' => stripslashes(preg_replace('/[\x00-\x1F\x7F]/u', ' ', $objectName . ' по адресу ' . $objectAddress)),
                        'lot_id' => $lot->id,
                        'type' => $type
                    ]);
                    $lotParam->parent_id = $mainLotParam->id;
                    $lotParam->save();
                    $response['mainLotParam'] = $mainLotParam;
                }

                if (isset($objectData[$objectTypeName])) {
                    $params = $lot->params()->get();
                    $objectType = $objectData[$objectTypeName];
                    if (isset($objectType['cadCostValue']) && $objectType['cadCostValue'] != null) {
                        $objectCadastralPrice = $objectType['cadCostValue'];
                        if (!$params->where(['param_id' => 1, 'value' => $objectCadastralPrice, 'parent_id' => $mainLotParam->id])->exists()) {
                            $lot->params()->attach(1, ['value' => $objectCadastralPrice, 'parent_id' => $mainLotParam->id]);
                        }
                    }
                    if (isset($objectType['area']) && $objectType['area'] != null) {
                        $objectCadatralArea = $objectTypeName === 'parcelData' ? $objectType['area']['value'] : $objectType['area'];
                        if (!$params->where(['param_id' => 2, 'value' => $objectCadatralArea, 'parent_id' => $mainLotParam->id])->exists()) {
                            $lot->params()->attach(2, ['value' => $objectCadatralArea, 'parent_id' => $mainLotParam->id]);
                        }
                    }
                    if (isset($objectType['floors']) && $objectType['floors'] != null) {
                        $floorsCount = $objectType['floors'];
                        if (!$params->where(['param_id' => 8, 'value' => $floorsCount, 'parent_id' => $mainLotParam->id])->exists()) {
                            $lot->params()->attach(8, ['value' => $floorsCount, 'parent_id' => $mainLotParam->id]);
                        }
                    }
                    if (isset($objectType['explCharYearBuilt']) && $objectType['explCharYearBuilt'] != null) {
                        $yearBuilt = $objectType['explCharYearBuilt'];
                        if (!$params->where(['param_id' => 9, 'value' => $yearBuilt, 'parent_id' => $mainLotParam->id])->exists()) {
                            $lot->params()->attach(9, ['value' => $yearBuilt, 'parent_id' => $mainLotParam->id]);
                        }
                    }
                    if (isset($objectType['materials']) && $objectType['materials'] != null) {
                        $materials = $objectType['materials'];
                        if (isset($materials['items'])) {
                            $items = $materials['items'];
                            if (isset($items['wallStr']) && $items['wallStr'] != null) {
                                $elementConstract = $items['wallStr'];
                                if (!$params->where(['param_id' => 10, 'value' => $elementConstract, 'parent_id' => $mainLotParam->id])->exists()) {
                                    $lot->params()->attach(10, ['value' => $elementConstract, 'parent_id' => $mainLotParam->id]);
                                }
                            }
                        }
                    }
                }

                return $response;
            }
        }
        return null;
    }

    public function getPkkObject($client, $cadastralNumber, $type=1, $lotParam, $lot, $mainLotParam) {
        $cadastralNumber = preg_replace('/:0+/', ':', $cadastralNumber);
        $res = $client->get('https://pkk.rosreestr.ru/api/features/'.$type.'/' . $cadastralNumber);
        if ($res->getStatusCode() == 200) {
            $data = json_decode($res->getBody(), true);
            if(isset($data['feature']) && $data['feature']) {
                $response = $data;
                $feature = $data['feature'];

                if(isset($feature['attrs'])) {
                    $featureAttrs = $feature['attrs'];
                    if(isset($featureAttrs['address'])) {
                        $response['address'] = $featureAttrs['address'];
                    }
                    if (!$mainLotParam) {
                        $objectName = $type == 1 ? 'Земельный участок' : 'Сооружение';
                        $objectAddress = isset($response['address']) && $response['address'] ? ' по адресу ' .$response['address'] : '';
                        $mainLotParam = LotParam::firstOrCreate([
                            'param_id' => 7,
                            'value' => stripslashes(preg_replace('/[\x00-\x1F\x7F]/u', ' ', $objectName . $objectAddress)),
                            'lot_id' => $lot->id,
                            'type' => $type === 1 ? 'landPlot' : 'building'
                        ]);
                        $lotParam->parent_id = $mainLotParam->id;
                        $lotParam->save();
                        $response['mainLotParam'] = $mainLotParam;
                    }
                    if(isset($featureAttrs['cad_cost'])) {
                        $objectCadastralPrice = $featureAttrs['cad_cost'];
                        if (!$lot->params()->where(['param_id' => 1, 'value' => $objectCadastralPrice, 'parent_id' => $mainLotParam->id])->exists()) {
                            $lot->params()->attach(1, ['value' => $objectCadastralPrice, 'parent_id' => $mainLotParam->id]);
                        }
                    }
                    if(isset($featureAttrs['area_value'])) {
                        $objectCadatralArea = $featureAttrs['area_value'];
                        if (!$lot->params()->where(['param_id' => 2, 'value' => $objectCadatralArea, 'parent_id' => $mainLotParam->id])->exists()) {
                            $lot->params()->attach(2, ['value' => $objectCadatralArea, 'parent_id' => $mainLotParam->id]);
                        }
                    }
                    if(isset($featureAttrs['date_cost'])) {
                        $response['date'] = $featureAttrs['date_cost'];
                    }
                }

                return $response;
            }
        }
        return null;
    }

    public function getCoordinatesFromYandex($client, $address, $lot, $mainLotParam) {
        if(Config::get('services.yandex.api_key')) {
            Cache::add('yandex', 0, now()->endOfDay());
            $requestQty = (integer)Cache::get('yandex');
            if($requestQty<1000) {
                //избавляемся от римских цифер
                $addressProccess = $this->roman2dec($address);
                if($addressProccess['replace'])
                {
                    $address = preg_replace($addressProccess['replace'], $addressProccess['replacement'], $address);
                }
                $res = $client->get('https://geocode-maps.yandex.ru/1.x/?'
                    .'apikey='.Config::get('services.yandex.api_key')
                    .'&geocode='.$address
                    .'&lang=ru_RU&format=json');
                Cache::increment('yandex');
                if ($res->getStatusCode() == 200) {
                    $data = json_decode($res->getBody(), true);
                    if(isset($data['response']['GeoObjectCollection']['featureMember'])) {
                        $featureMember = $data['response']['GeoObjectCollection']['featureMember'];
                        if(is_array($featureMember)) {
                            $featureMember = $data['response']['GeoObjectCollection']['featureMember'][0];
                        }
                        if(isset($featureMember['GeoObject']['Point']['pos'])) {
                            $coordinatesString = $featureMember['GeoObject']['Point']['pos'];
                            if($coordinatesString && $coordinatesString != null) {
                                $coordinates = explode(' ', $coordinatesString);
                                $coord1 = (float)$coordinates[0];
                                $coord2 = (float)$coordinates[1];
                                //пытаемся ограничивать координатами России
                                if($coord1>=18 && $coord1<=181 && $coord2 >= 18 && $coord2 <= 181) {
                                    if (!$lot->params()->where(['param_id' => 11, 'value' => $coordinatesString, 'parent_id' => $mainLotParam->id])->exists()) {
                                        $lot->params()->attach(11, ['value' => $coordinatesString, 'parent_id' => $mainLotParam->id]);
                                    }
                                }
                            }

                        }
                    }
                    return $data;
                }
            }
            return 'Status 500';
        }
        return null;
    }

    public function roman2dec ($linje) {
        # Fixing variable so it follows convention
        # Removing all not-roman letters
        $linje = preg_replace("/[^IVXLCDM]/", "",  strtoupper($linje));

        # Defining variables
        $romanLettersToNumbers = array("M" => 1000, "D" => 500, "C" => 100, "L" => 50, "X" => 10, "V" => 5, "I" => 1);

        $oldChunk = 1001;
        $calculation=0;
        # Looping through line
        for($start = 0; $start < strlen($linje); $start++) {
            $chunk = substr($linje, $start, 1);

            $chunk = $romanLettersToNumbers[$chunk];

            if($chunk <= $oldChunk) {
                $calculation += $chunk;
            } else {
                $calculation += ($chunk - (2 * $oldChunk));
            }

            $oldChunk = $chunk;
        }

        # Summing it up
        return ['replace'=>$linje, 'replacement' => $calculation];
    }

    /*
     * https://pkk.rosreestr.ru/api/features/1/42:24:101041:1117
     *
     * LAND_LOT (number)                       : Земельные участки (1)
LAND_QUARTER (number)                   : Кварталы (2)
LAND_AREA (number)                      : Районы (3)
LAND_DISTRICT (number)                  : Округи (4)
CCO (number)                            : ОКСы (5) //Здания, Сооружения, Объекты незавершенного строительства
TERRITORIAL_AREA (number)               : Территориальные зоны (6)
BOUNDARY (number)                       : Границы (7)
BOUNDARY_REFERENCE_NETWORK (number)     : ОМС (9)
USE_RESTRICTED_ZONE (number)            : ЗОУИТы (10)
FORESTRY (number)                       : Лесничества и лесопарки (12)
BUILDING_LINE (number)                  : Красные линии (13)
LAND_LOT_LAYOUT (number)                : Схемы расположения ЗУ (15)
FREE_ECONOMIC_ZONE (number)             : Свободные экономические зоны (16)
    */
}
