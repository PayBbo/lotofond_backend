<?php

namespace App\Http\Services\Parse;

use App\Models\Lot;
use App\Models\LotParam;
use App\Models\Param;
use App\Models\Region;

class ParseDataFromRosreestrService
{
    protected $cadastralNumber;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($cadastralNumber)
    {
        $this->cadastralNumber = $cadastralNumber;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $cadastralNumber = preg_replace("/::/", ':0:', preg_replace("/(?<=:)(0*)/", '', $this->cadastralNumber));
        $client = new \GuzzleHttp\Client(['verify' => false]);
        $res = $client->get('http://rosreestr.ru/api/online/fir_object/' . $cadastralNumber);
        if ($res->getStatusCode() == 200) {
            $data = json_decode($res->getBody(), true);
            $lotParam = LotParam::where('value', $this->cadastralNumber)->first();
            if ($lotParam) {
                $lot = Lot::find($lotParam->lot_id);
                $objectAddress = $data['objectData']['objectAddress']['mergedAddress'];
                $objectRegion = $data['objectData']['objectAddress']['region'];
                $region = Region::where('numbers', 'LIKE', '%' . $objectRegion . '%')->first();
                if ($region) {
                    $objectAddress = $region->title .', '.$objectAddress;
                    if (!$lot->regions->contains($region)) {
                        $lot->regions()->attach($region, ['is_debtor_region' => false]);
                    }
                }
                $objectName = 'Участок';
                if($data['type'] == 'parcel'){
                    $flag = $data['parcelData']['oksFlag'];
                    if($flag == 1){
                        switch ($data['parcelData']['oksType']){
                            case 'building':{
                                $objectName = 'Здание';
                                break;
                            }
                            case 'construction':{
                                $objectName = 'Сооружение';
                                break;
                            }
                            case 'flat':{
                                $objectName = 'Квартира';
                                break;
                            }
                        }
                    }else{
                        $objectName = 'Земельный участок';
                    }
                }elseif ($data['type'] == 'premises'){
                    $objectName = 'Помещение';
                }
                $mainLotParam = LotParam::create([
                    'param_id' => 7,
                    'value' => $objectName.' по адресу ' . $objectAddress,
                    'lot_id' => $lot->id
                ]);
                $lotParam->parent_id = $mainLotParam->id;
                $lotParam->save();

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

    }
}
