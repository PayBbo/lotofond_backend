<?php

namespace App\Http\Services;

use App\Http\Services\Parse\ParseDataFromRosreestrService;
use App\Models\EgrnStatement;
use App\Models\Lot;
use App\Models\LotParam;
use App\Models\Param;
use App\Models\Region;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class ReestrApiService
{
    protected $auth_token;

    public function __construct()
    {
        $this->auth_token = config('reestr.auth_token');
    }

    public function searchByCadastralNumber($cadastralNumber)
    {
        try {
            $client = new Client();
            $options = [
                'form_params' => [
                    'cad_num' => $cadastralNumber
                ]];
            $request = new Request('POST', 'https://reestr-api.ru/v1/search/cadastr?auth_token=' . $this->auth_token);
            $res = $client->sendAsync($request, $options)->wait();
            $response = json_decode($res->getBody(), true);
            if ($response['query'] != 'success' || $response['found'] < 1) {
                return false;
            }
            $lotParam = LotParam::where('value', $cadastralNumber)->first();
            if (!$lotParam) {
                return false;
            }
            $lot = Lot::find($lotParam->lot_id);
            $objectAddress = $response['list'][0]['address'];
            $objectRegion = substr($cadastralNumber, 0, strpos($cadastralNumber, ':'));
            $region = Region::where('numbers', 'LIKE', '%' . $objectRegion . '%')->first();
            if ($region) {
                if (!$lot->regions->contains($region)) {
                    $lot->regions()->attach($region, ['is_debtor_region' => false]);
                }
            }
            $objectName = $response['list'][0]['obj_type'];
            $type = 'other';
            $types = [
                'здание' => 'building',
                'сооружение' => 'construction',
                'квартира' => 'flat',
                'земельный участок' => 'landPlot',
                'помещение' => 'premise'
            ];
            foreach ($types as $key => $value) {
                if (strpos(mb_strtolower($objectName), $key) !== false) {
                    $type = $value;
                    break;
                }
            }
            $mainLotParam = LotParam::create([
                'param_id' => 7,
                'value' => $objectName . ' по адресу ' . $objectAddress,
                'lot_id' => $lot->id,
                'type' => $type
            ]);
            $lotParam->parent_id = $mainLotParam->id;
            $lotParam->save();

            $objectCadastralPrice = $response['list'][0]['cad_cost'];
            if (strlen($objectCadastralPrice) > 0) {
                $objectCadastralPrice = floatval(str_replace(',', '.', $objectCadastralPrice));
                if (!$lot->params()->where(['param_id' => 1, 'value' => $objectCadastralPrice, 'parent_id' => $mainLotParam->id])->exists()) {
                    $lot->params()->attach(Param::find(1), ['value' => $objectCadastralPrice, 'parent_id' => $mainLotParam->id]);
                }
            }
            $objectCadatralArea = $response['list'][0]['area'];
            if (strlen($objectCadatralArea) > 0) {
                $objectCadatralArea = floatval(str_replace(',', '.', $objectCadatralArea));
                if (!$lot->params()->where(['param_id' => 2, 'value' => $objectCadatralArea, 'parent_id' => $mainLotParam->id])->exists()) {
                    $lot->params()->attach(Param::find(2), ['value' => $objectCadatralArea, 'parent_id' => $mainLotParam->id]);
                }
            }

            return true;
        }catch (\Exception $e){
          //  logger('reestr api exception '.$e->getMessage());
            return false;
        }
    }

    public function createEgrnOrder($application)
    {
        $client = new Client();
        $options = [
            'form_params' => [
                'cad_num' => $application->cadastral_number,
                'order_type' => '1'
                //'convert_format'=>'report'
            ]];
        $request = new Request('POST', 'https://reestr-api.ru/v1/order/create/?auth_token=' . $this->auth_token);
        $res = $client->sendAsync($request, $options)->wait();
        $response = json_decode($res->getBody(), true);
        if ($response['query'] == 'success') {
            EgrnStatement::create([
                'order_id' => $response['order_id'],
                'application_id' => $application->id
            ]);
            $application->status = 'inProgress';
            $application->save();
        } else {
            $application->status = 'rejectedBySystem';
            $application->save();
        }
    }

    //order_id - Уникальный идентификатор заказа.
    // Данный параметр возвращает метод Create при успешном создании заказа.
    // Для проверки статуса нескольких заказов, необходимо разделить идентификаторы точкой с запятой ";".
    // Пример: “036e8c10yda24703b81747d854bf7ed4; a60bb9cd3fc74n9d85e362fbecd433a4”.

    public function checkEgrnOrder($orders)
    {
        $client = new Client();
        $options = [
            'form_params' => [
                'order_id' => $orders
            ]];
        $request = new Request('POST', 'https://reestr-api.ru/v1/order/check?auth_token=' . $this->auth_token);
        $res = $client->sendAsync($request, $options)->wait();
        $response = json_decode($res->getBody(), true);
        logger($response);
        return $response;
    }


}
