<?php

namespace App\Http\Services;

use App\Models\EgrnStatement;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class ReestrApiService
{
    protected $auth_token;

    public function __construct()
    {
        $this->auth_token = config('reestr.auth_token');
    }

    public function searchByCadastralNumber($cadastralNumber){
        $client = new Client();
        $options = [
            'form_params' => [
                'cad_num' => $cadastralNumber
            ]];
        $request = new Request('POST', 'https://reestr-api.ru/v1/search/cadastr?auth_token='. $this->auth_token);
        $res = $client->sendAsync($request, $options)->wait();
        $response =  json_decode($res->getBody(), true);
        logger($response);
        return $response;
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
        $response =  json_decode($res->getBody(), true);
        if ($response['query'] == 'success') {
            EgrnStatement::create([
                'order_id' => $response['order_id'],
                'application_id' => $application->id
            ]);
            $application->status = 'inProgress';
            $application->save();
        }else{
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
        $response =  json_decode($res->getBody(), true);
        logger($response);
        return $response;
    }



}
