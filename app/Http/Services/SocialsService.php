<?php

namespace App\Http\Services;


use App\Exceptions\CustomExceptions\BaseException;
use Exception;

class SocialsService
{
    private $token;
    public function decode()
    {
        if (!$this->token) {
            return null;
        }
        try {
            $tokenParts = explode(".", $this->token);
            $tokenHeader = base64_decode($tokenParts[0]);
            $tokenPayload = base64_decode(str_replace(array('-', '_'), array('+', '/'), $tokenParts[1]));
            $jwtHeader = json_decode($tokenHeader);
            $jwtPayload = json_decode($tokenPayload);
            return $jwtPayload;
        }
        catch (Exception $ex){
            throw new BaseException('ERR_AUTHORIZATION_FAILED', 422, __('validation.user_not_found'));
        }
    }

    public function getSub()
    {
        $appleSignInPayload = $this->decode();
        if(is_null($appleSignInPayload)){
            throw new BaseException('ERR_AUTHORIZATION_FAILED', 422, __('validation.user_not_found'));
        }
        return $appleSignInPayload->sub;
    }
    public function setToken($token){
        $this->token = $token;
    }
}
