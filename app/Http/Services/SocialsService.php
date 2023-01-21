<?php

namespace App\Http\Services;


use App\Exceptions\CustomExceptions\BaseException;
use App\Models\SocialAccount;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Hash;

class SocialsService
{
    private $token;

    public function __construct($token){
        $this->token = $token;
    }

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

    public function saveUser($request){
        $password = strval(mt_rand(10000000, 99999999));
        $sub = $this->getSub();
        $social = SocialAccount::where(['provider_id' => $sub, 'provider' => $request->grantType])->first();
        $userPassword = null;
        if (!$social) {
            $user = User::create([
                'password' => Hash::make($password),
                'email_verified_at' => Carbon::now()->setTimezone('Europe/Moscow'),
                'not_settings' => [
                    'favouriteEventStart' => 1,
                    'favouriteEventEnd' => 1,
                    'favouriteApplicationStart' => 1,
                    'favouriteApplicationEnd' => 1,
                    'favouriteResult' => 1,
                    'favouritePriceReduction' => 1
                ]
            ]);
            $social = SocialAccount::create([
                'user_id' => $user->id,
                'provider_id' => $sub,
                'provider' => $request->grantType
            ]);
        } else {
            $user = User::find($social->user_id);
            $userPassword = $user->password;
        }
        $username = $sub . ' ' . $request->grantType;
        $user->password = Hash::make($password);
        $user->save();
        $generateToken = new GenerateAccessTokenService();
        $token = $generateToken->generateToken($request, $username, $password);
        if (!is_null($userPassword)) {
            $user->password = $userPassword;
            $user->save();
        }
        if (isset($request->deviceToken)) {
            $deviceTokenService = new DeviceTokenService($user, $request->deviceToken);
            $deviceTokenService->saveDeviceToken();
        }
        return $token;
    }

    public function checkIfExists($grantType){
        $sub = $this->getSub();
        $social = SocialAccount::where(['user_id' => auth()->id(), 'provider' => $grantType, 'provider_id' => $sub])->first();
        if (!$social) {
            throw new BaseException("ERR_VALIDATION_FAILED_SOCIALS", 422, __('validation.user_not_found'));
        }
    }
}
