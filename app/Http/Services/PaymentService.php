<?php

namespace App\Http\Services;

use App\Models\User;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\MessageFormatter;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class PaymentService
{
    protected $token;
    protected $merchantId;
    protected $returnUrl;
    protected $callbackUrl;
    protected $testMode;

    public function __construct()
    {
        $this->token = config('paymaster.token');
        $this->merchantId = config('paymaster.merchant_id');
        $this->returnUrl = config('paymaster.return_url');
        $this->callbackUrl = config('paymaster.callback_url');
        $this->testMode = config('paymaster.test_mode');
    }

    public function paymentRequest($paymentId, $tariff)
    {
        $client = new \GuzzleHttp\Client();
       /* $logger = new Logger('GuzzleLogger');
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
        $user = User::find(auth()->id());
        $response = $client->request('POST', 'https://paymaster.ru/api/v2/invoices',
            [
                RequestOptions::HEADERS => [
                    'Authorization'=> 'Bearer '.$this->token,
                    'Content-Type'=>'application/json'
                ],
                RequestOptions::JSON => [
                    'merchantId' => $this->merchantId,
                    'testMode'=>$this->testMode,
                    'invoice'=>[
                        'description'=>$tariff->description,
                        'orderNo'=>(string)$paymentId
                    ],
                    'amount'=>[
                        'value'=>$tariff->price,
                        'currency'=>'RUB'
                    ],
                    'paymentMethod'=>'BankCard',
                    'protocol'=>[
                        'returnUrl' => $this->returnUrl,
                        'callbackUrl' => $this->callbackUrl
                    ],
                    'customer'=>[
                        'email'=>$user->email,
                        'phone'=>$user->phone,
                        'account'=>(string)$user->id
                    ],
                    'receipt'=>[
                        'client'=>[
                            'email'=>$user->email,
                            'phone'=>$user->phone
                        ],
                        'items'=>[
                            [
                                'name'=>$tariff->title,
                                'quantity'=>1,
                                'price'=>$tariff->price,
                                'vatType'=>'None',
                                'paymentSubject'=>'Service',
                                'paymentMethod'=>'FullPayment'
                            ]
                        ]
                    ]

                ]
            ]);
        return json_decode($response->getBody(), true);
    }

    public function getPaymentStatus($paymentId)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://paymaster.ru/api/v2/payments/'.$paymentId,
            [
                RequestOptions::HEADERS => [
                    'Authorization'=> 'Bearer '.$this->token,
                ]
            ]);
        return json_decode($response->getBody(), true);
    }
}
