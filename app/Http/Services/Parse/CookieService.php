<?php

namespace App\Http\Services\Parse;

use App\Utilities\slowAES\AES;
use App\Utilities\slowAES\cryptoHelpers;

class CookieService
{
    protected $a;
    protected $b;
    protected $c;

    public function __construct($a, $b, $c)
    {
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
    }

    private function getFedresursCookies() {
        $arr = array('a' =>  $this->a, 'b' => $this->b, 'c' => $this->c);
        $cryptoHelpers = new cryptoHelpers();
        $aes = new AES();
        return $cryptoHelpers->toHex($aes->decrypt($cryptoHelpers->toNumbers($arr['c']), 32,2, $cryptoHelpers->toNumbers($arr['a']), count($cryptoHelpers->toNumbers($arr['a'])), $cryptoHelpers->toNumbers($arr['b'])));
    }

    public function getFedresursHeadersOptions() {
        $cookies = $this->getFedresursCookies();
        $headers = [
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.160 YaBrowser/22.5.2.615 Yowser/2.5 Safari/537.36',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
            'Cache-Control: no-cache',
            'Connection: keep-alive',
            'Content-disposition: attachment',
            'Cookie: bankrotcookie=' . $cookies
        ];
        return array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers
        );
    }
}
