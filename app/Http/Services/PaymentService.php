<?php

namespace App\Http\Services;

use GuzzleHttp\RequestOptions;

class PaymentService
{
    protected $username;
    protected $password;
    protected $returnUrl;
    protected $failUrl;
    protected $language;

    public function __construct($language)
    {
        $this->username = config('sberbank.username');
        $this->password = config('sberbank.password');
        $this->returnUrl = config('sberbank.success_url');
        $this->failUrl = config('sberbank.fail_url');
        $this->language = $language;
    }

    public function paymentRequest($paymentId, $sum)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://3dsec.sberbank.ru/payment/rest/register.do',
            [
                RequestOptions::HEADERS => [
                    'Cache-Control' => 'no-cache'
                ],
                RequestOptions::QUERY => [
                    'userName' => $this->username,
                    'password' => $this->password,
                    'orderNumber' => $paymentId,
                    'amount' => $sum * 100,
                    'currency' => 643,
                    'language' => $this->language,
                    'returnUrl' => $this->returnUrl,
                    'failUrl' => $this->failUrl
                ]
            ]);
        return json_decode($response->getBody(), true);
    }

    public function getOrderStatus($paymentId)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://3dsec.sberbank.ru/payment/rest/getOrderStatusExtended.do',
            [
                RequestOptions::HEADERS => [
                    'Cache-Control' => 'no-cache'
                ],
                RequestOptions::QUERY => [
                    'userName' => $this->username,
                    'password' => $this->password,
                    'orderId' => $paymentId
                ]
            ]);
        return json_decode($response->getBody(), true);
    }
}
