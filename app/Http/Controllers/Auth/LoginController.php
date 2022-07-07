<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Services\GenerateAccessTokenService;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{
    public function login(LoginRequest $request){
        switch ($request->grantType){
            case 'email':{
                $user = User::where('email', $request->email)->first();
                $username = $request->email;
                break;
            }
            case 'phone':{
                $user = User::where('phone', $request->phone)->first();
                $username = $request->phone;
                break;
            }
            case 'gosuslugi':{
                //
                break;
            }
        }
        if ($request->grantType == 'email' || $request->grantType == 'phone') {
            if (!Hash::check($request->password, $user->password)) {
                throw new BaseException("ERR_VALIDATION_FAILED_PASSWORD", 422, __('validation.current_password'));
            }
        }
        $generateToken = new GenerateAccessTokenService();
        $token =  $generateToken->generateToken($request, $username, $request->password);
        return response($token, 200);
    }

    public function refreshToken(Request $req){
        $req->validate([
            'refreshToken'=>['required', 'string']
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

    public function logout(){
        try {
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
