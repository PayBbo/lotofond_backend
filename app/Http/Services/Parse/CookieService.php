<?php

namespace App\Http\Services\Parse;

use App\Utilities\slowAES\AES;
use App\Utilities\slowAES\cryptoHelpers;

class CookieService
{
    public function getFedresursCookies() {
        $arr = array('a' => '8b3d7f4e9ab55daee9fb89016f8a76a6', 'b' => 'a9ee0b0a96986edc98bfe6a739b457ad', 'c' => '535a97a4d149ee29ac533ad1ebf746da');
        $cryptoHelpers = new cryptoHelpers();
        $aes = new AES();
        return $cryptoHelpers->toHex($aes->decrypt($cryptoHelpers->toNumbers($arr['c']), 32,2, $cryptoHelpers->toNumbers($arr['a']), count($cryptoHelpers->toNumbers($arr['a'])), $cryptoHelpers->toNumbers($arr['b'])));
    }

    public function getFedresursHeadersOptions() {
        $headers = [
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.160 YaBrowser/22.5.2.615 Yowser/2.5 Safari/537.36',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
            'Cache-Control: no-cache',
            'Connection: keep-alive',
            'Content-disposition: attachment',
            'Cookie: bankrotcookie=' . $this->getFedresursCookies()
        ];
        return array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers
        );
    }
}
