<?php

namespace App\Http\Services;

use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Cache;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class PushNotificationService
{
    protected $title;
    protected $body;
    protected $user_id;
    protected $type;

    public function __construct($title, $body, $user_id, $type){
        $this->title = $title;
        $this->body = $body;
        $this->user_id = $user_id;
        $this->type = $type;
    }

    public function sendPushNotification(){
        $user = User::find($this->user_id);
        $date = Carbon::now()->setTimezone('Europe/Moscow');
        $tokens = $user->deviceTokens->where('created_at', '>', $date->subMonths(2)->format('Y-m-d H:i'))->pluck('token')->toArray();
        if(count($tokens)>0) {
            try {
                $SERVER_API_KEY = config('larafirebase.authentication_key');

                $data = [
                    "registration_ids" => $tokens,
                    "data"=>[
                        "type"=>$this->type
                    ],
                    "notification" => [
                        "title" => $this->title,
                        "body" => $this->body
                    ]
                ];
                $dataString = json_encode($data);

                $headers = [
                    'Authorization: key=' . $SERVER_API_KEY,
                    'Content-Type: application/json',
                ];

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

                $response = curl_exec($ch);
                logger("SEND PUSH");
                curl_close($ch);
            }catch(\Exception $e){
                logger($e);
               /* $code = $this->sendPushNotificationToHuawei($tokens);
                if($code == 80200003){
                    Cache::forget('huawei_access_token');
                    $this->sendPushNotificationToHuawei($tokens);
                }*/
            }
        }
    }

    public function sendPushNotificationToHuawei($tokens){
        try{
            $client_id = config('larafirebase.huawei_client_id');
            $accessToken = $this->getAuthToken();
            $client = new \GuzzleHttp\Client();
            /*$logger = new Logger('GuzzleLogger');
            $logger->pushHandler(new StreamHandler(storage_path('logs/guzzle.log')));
            $stack = HandlerStack::create();
            $stack->push(
                Middleware::log(
                    $logger,
                    new MessageFormatter('{req_body} - {res_body}')
                )
            );
            $client = new \GuzzleHttp\Client(
                [
                    'handler' => $stack,
                ]
            );*/

            $response = $client->request('POST',  config('larafirebase.huawei_send_url'),
                [
                    RequestOptions::HEADERS => [
                        'Content-Type' => 'application/json',
                        'Authorization'=>'Bearer  '. $accessToken
                    ],
                    RequestOptions::FORM_PARAMS => [
                        'validate_only' => true,
                        'message'=>[
                            'data'=>[
                                'type'=>$this->type
                            ],
                            'notification'=>[
                                'title' => $this->title,
                                'body' => $this->body
                            ],
                            'token'=>$tokens
                        ]
                    ]
                ]);
            $res = json_decode($response->getBody(), true);

            return $res['code'];

        }catch(\Exception $e){
            logger($e);
        }
    }


    public function getAuthToken(){
        if(!Cache::has('huawei_access_token')) {
            $client = new \GuzzleHttp\Client();
            /*$logger = new Logger('GuzzleLogger');
            $logger->pushHandler(new StreamHandler(storage_path('logs/guzzle.log')));
            $stack = HandlerStack::create();
            $stack->push(
                Middleware::log(
                    $logger,
                    new MessageFormatter('{req_body} - {res_body}')
                )
            );
            $client = new \GuzzleHttp\Client(
                [
                    'handler' => $stack,
                ]
            );*/

            $response = $client->request('POST', config('larafirebase.huawei_auth_url'),
                [
                    RequestOptions::HEADERS => [
                        'Content-Type' => 'application/x-www-form-urlencoded'
                    ],
                    RequestOptions::FORM_PARAMS => [
                        'grant_type' => 'client_credentials',
                        'client_id' => config('larafirebase.huawei_client_id'),
                        'client_secret' => config('larafirebase.huawei_client_secret')
                    ]
                ]);
            $res = json_decode($response->getBody(), true);

            if (array_key_exists('access_token', $res)) {
                Cache::put('huawei_access_token', $res['access_token'], Carbon::now()->setTimezone('Europe/Moscow')->addSeconds($res['expires_in']  - 60));
            }
        }
        return Cache::get('huawei_access_token');
    }


}
