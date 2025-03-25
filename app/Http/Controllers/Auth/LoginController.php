<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Services\DeviceTokenService;
use App\Http\Services\GenerateAccessTokenService;
use App\Http\Services\SocialsService;
use App\Http\Services\UserAgentService;
use App\Models\SocialAccount;
use App\Models\User;
use App\Traits\TelegramTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{
    use TelegramTrait;

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
                $user = User::where('phone', preg_replace('/\D/', '',$request->phone))->first();
                $username = $request->phone;
                $password = $request->password;
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
                $socialService = new SocialsService($request->token);
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
            case 'bot': {
                $user = User::where('tg_id', '=', $request->id)->orWhere(function ($query) use($request) {
                    $query->when($request->phone, function ($q) use($request) {
                       $q->where('phone', preg_replace('/\D/', '',$request->phone));
                    })->when($request->email, function ($q) use($request) {
                       $q->where('email', $request->email);
                    });
                })->first();
                $password = $request->password;
                logger('bot login req = '.json_encode($request->all()));
                logger('bot login user = '.json_encode($user));
                try {
                    if (!$this->checkTelegramAuthorization($request->initData, Config::get('telegram.bots.mybot.token'))) {
                        // данные не прошли проверку "Ошибка проверки данных входа"
                        throw new BaseException("ERR_VALIDATION_FAILED_SOCIALS", 422, __('validation.user_not_found'));
                    }
                }
                catch (\Exception $e) {
                    throw new BaseException("ERR_VALIDATION_FAILED_SOCIALS", 422, "Ошибка проверки данных входа");
                }
                $password = strval(mt_rand(10000000, 99999999));
                $password = $request->password;
                if(!$user) {
                    $user = $this->addNewTelegramUser($request, $password);
                    logger('bot login new user = '.json_encode($user));
                }
                else {
                    if(!$user->tg_id) {
                        $user->tg_id = $request->get('id', null);
                        $user->tg_username = $request->get('username', null);
                        $user->tg_connected_at = Carbon::now()->setTimezone('Europe/Moscow');
                    }
                    $userPassword = $user->password;
                    $user->password = Hash::make($password);
                    $user->save();
                    $username = $request->phone ?: ($request->email ?:$user->tg_username);
                }

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
        logger('bot login token = '.json_encode($token));
        if (isset($request->deviceToken)) {
            $deviceTokenService = new DeviceTokenService($user, $request->deviceToken);
            $deviceTokenService->saveDeviceToken();
        }
        if(!is_null($userPassword)){
            $user->password = $userPassword;
            $user->save();
        }
        $userAgentService = new UserAgentService();
        $userAgentService->getUserAgent($request->userAgent(), $user);
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
                "scope" => $req->get('scope', '')

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
