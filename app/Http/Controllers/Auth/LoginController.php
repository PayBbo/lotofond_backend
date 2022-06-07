<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\AccessTokenResource;
use App\Http\Services\GenerateAccessTokenService;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
                throw new BaseException("ERR_VALIDATION_FAILED", 422, "User password doesn't match our credentials");
            }
        }
        $generateToken = new GenerateAccessTokenService();
        $token =  $generateToken->generateToken($request, $username, $request->password);
        return response($token, 200);
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
