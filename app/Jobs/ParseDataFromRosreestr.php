<?php

namespace App\Jobs;

use App\Models\Lot;
use App\Models\LotParam;
use App\Models\Param;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ParseDataFromRosreestr implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        $cadastralNumber = preg_replace("/(?<=:)(0*)/", '', $this->cadastralNumber);
        $client = new \GuzzleHttp\Client(['verify' => false]);
        $res = $client->get('http://rosreestr.ru/api/online/fir_object/'.$cadastralNumber);
        if($res->getStatusCode() == 200){
            $data = $res->getBody();
            $lotParam = LotParam::where('value', $this->cadastralNumber)->first();
            if($lotParam){
                $lot = Lot::find($lotParam->lot_id);
                $objectName = $data['objectData']['objectName'];
                $objectAddress = $data['objectData']['objectAddress']['mergedAddress'];
                $mainLotParam = LotParam::create([
                    'param_id'=>3,
                    'value'=>$objectName . ' по адресу '.$objectAddress,
                    'lot_id'=>$lot->id
                ]);
                $lotParam->parent_id = $mainLotParam->id;
                $lotParam->save();
               // $objectRegion = $data['objectData']['objectAddress']['region'];
                $objectCadastralPrice = $data['parcelData']['cadCost'];
                $lot->params()->attach(Param::find(1), ['value' => $objectCadastralPrice, 'parent_id'=>$mainLotParam->id]);
                $objectCadatralArea = $data['parcelData']['areaValue'];
                $lot->params()->attach(Param::find(2), ['value' => $objectCadatralArea, 'parent_id'=>$mainLotParam->id]);

            }
        }

    }
}
