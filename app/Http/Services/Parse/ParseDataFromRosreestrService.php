<?php

namespace App\Http\Services\Parse;

use App\Models\Lot;
use App\Models\LotParam;
use App\Models\Param;
use App\Models\Region;

class ParseDataFromRosreestrService
{
    protected $cadastralNumber;
    protected $lotId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($cadastralNumber, $lotId)
    {
        $this->cadastralNumber = $cadastralNumber;
        $this->lotId = $lotId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $cadastralNumber = preg_replace("/::/", ':0:', preg_replace("/(?<=:)(0*)/", '', $this->cadastralNumber));
            $client = new \GuzzleHttp\Client(['verify' => false]);
            $res = $client->get('http://rosreestr.ru/api/online/fir_object/' . $cadastralNumber);
            if ($res->getStatusCode() == 200) {
                $data = json_decode($res->getBody(), true);
                $lotParam = LotParam::where(['value', $this->cadastralNumber, 'lot_id'=>$this->lotId])->first();
                if ($lotParam) {
                    $lot = Lot::find($lotParam->lot_id);
                    $objectAddress = $data['objectData']['objectAddress']['mergedAddress'];
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
                    } elseif ($data['type'] == 'premises') {
                        $objectName = 'Помещение';
                        $type = 'premise';
                    }
                    $mainLotParam = LotParam::find($lotParam->parent_id);
                    if(!$mainLotParam) {
                        $mainLotParam = LotParam::create([
                            'param_id' => 7,
                            'value' => stripslashes(preg_replace('/[\x00-\x1F\x7F]/u', ' ', $objectName . ' по адресу ' . $objectAddress)),
                            'lot_id' => $lot->id,
                            'type' => $type
                        ]);
                        $lotParam->parent_id = $mainLotParam->id;
                        $lotParam->save();
                    }

                    $objectCadastralPrice = $data['parcelData']['cadCost'];
                    if (!$lot->params()->where(['param_id' => 1, 'value' => $objectCadastralPrice, 'parent_id' => $mainLotParam->id])->exists()) {
                        $lot->params()->attach(Param::find(1), ['value' => $objectCadastralPrice, 'parent_id' => $mainLotParam->id]);
                    }
                    $objectCadatralArea = $data['parcelData']['areaValue'];
                    if (!$lot->params()->where(['param_id' => 2, 'value' => $objectCadatralArea, 'parent_id' => $mainLotParam->id])->exists()) {
                        $lot->params()->attach(Param::find(2), ['value' => $objectCadatralArea, 'parent_id' => $mainLotParam->id]);
                    }
                    $floorsCount = $data['parcelData']['oksFloors'];
                    if (!$lot->params()->where(['param_id' => 8, 'value' => $floorsCount, 'parent_id' => $mainLotParam->id])->exists()) {
                        $lot->params()->attach(Param::find(8), ['value' => $floorsCount, 'parent_id' => $mainLotParam->id]);
                    }
                    $yearBuilt = $data['parcelData']['oksYearBuilt'];
                    if (!$lot->params()->where(['param_id' => 9, 'value' => $yearBuilt, 'parent_id' => $mainLotParam->id])->exists()) {
                        $lot->params()->attach(Param::find(9), ['value' => $yearBuilt, 'parent_id' => $mainLotParam->id]);
                    }
                    $elementConstract = $data['parcelData']['oksElementsConstructStr'];
                    if (!$lot->params()->where(['param_id' => 9, 'value' => $elementConstract, 'parent_id' => $mainLotParam->id])->exists()) {
                        $lot->params()->attach(Param::find(10), ['value' => $elementConstract, 'parent_id' => $mainLotParam->id]);
                    }
                }
            }
        } catch (\Exception $e) {

        }

    }
}
