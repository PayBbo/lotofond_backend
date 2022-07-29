<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Services\DeviceTokenService;
use App\Http\Services\GenerateAccessTokenService;
use App\Http\Services\SocialsService;
use App\Models\SocialAccount;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $userPassword = null;
        switch ($request->grantType) {
            case 'email':
            {
                $user = User::where('email', $request->email)->first();
                $username = $request->email;
                $password = $request->password;
                break;
            }
            case 'phone':
            {
                $user = User::where('phone', $request->phone)->first();
                $username = $request->phone;
                break;
            }
            /*case 'gosuslugi':
            {

                break;
            }*/
            case 'google':
            case 'apple':
            {
                $password = strval(mt_rand(10000000, 99999999));
                $socialService = new SocialsService();
                $socialService->setToken($request->token);
                $sub = $socialService->getSub();
                $social = SocialAccount::where(['provider_id' => $sub, 'provider' => $request->grantType])->first();
                if(!$social){
                    throw new BaseException("ERR_VALIDATION_FAILED_SOCIALS", 422, __('validation.user_not_found'));
                }
                $username = $sub . ' '.$request->grantType;
                $user = User::where('id', $social->user_id)->first();
                $userPassword = $user->password;
                $user->password=Hash::make($password);
                $user->save();
                break;
            }

        }
        if ($request->grantType == 'email' || $request->grantType == 'phone') {
            if (!Hash::check($request->password, $user->password)) {
                throw new BaseException("ERR_VALIDATION_FAILED_PASSWORD", 422, __('validation.current_password'));
            }
        }
        $generateToken = new GenerateAccessTokenService();
        $token = $generateToken->generateToken($request, $username, $password);
        if (isset($request->deviceToken)) {
            $deviceTokenService = new DeviceTokenService($user, $request->deviceToken);
            $deviceTokenService->saveDeviceToken();
        }
        if(!is_null($userPassword)){
            $user->password = $userPassword;
            $user->save();
        }
        return response($token, 200);
    }

    public function refreshToken(Request $req)
    {
        $req->validate([
            'refreshToken' => ['required', 'string']
        ]);
        $client = DB::table('oauth_clients')
            ->where('password_client', true)
            ->first();
        $refreshToken = $req->refreshToken;
        try {
            $req->merge([
                "grant_type" => "refresh_token",
                "client_id" => $client->id,
                "client_secret" => $client->secret,
                "refresh_token" => $refreshToken,
                "scope" => ""

            ]);
            $tokenRequest = $req->create(
                '/oauth/token',
                'post'
            );
            $instance = Route::dispatch($tokenRequest);
            $token = json_decode($instance->getContent());
            return response([
                'accessToken' => $token->access_token,
                'expiresIn' => $token->expires_in,
                'refreshToken' => $token->refresh_token
            ], 200);
        } catch (Exception $e) {
            throw new BaseException('ERR_VALIDATION_REFRESH_TOKEN', 422, 'Refresh token error');
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = User::find(auth()->id());
            if (isset($request->deviceToken)) {
                $deviceTokenService = new DeviceTokenService($user, $request->deviceToken);
                $deviceTokenService->deleteDeviceToken();
            }
            $accessToken = auth()->user()->token();
            $refreshToken = DB::table('oauth_refresh_tokens')
                ->where('access_token_id', $accessToken->id)
                ->update([
                    'revoked' => true
                ]);
            $accessToken->revoke();
            return response(null, 200);
        } catch (Exception $e) {
            throw new BaseException("ERR_LOGOUT_FAILED", $e->getCode(), $e->getMessage());
        }
    }
}
