<?php

namespace App\Http\Services;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Resources\AccessTokenResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class GenerateAccessTokenService
{
    public function generateToken(Request $req, $username, $password)
    {
        $client = DB::table('oauth_clients')
            ->where('password_client', true)
            ->first();
        try {
            $req->merge([
                "grant_type" => "password",
                "client_id" => $client->id,
                "client_secret" => $client->secret,
                "username" => $username,
                "password" => $password,
            ]);
            $tokenRequest = $req->create(
                '/oauth/token',
                'post'
            );
            $instance = Route::dispatch($tokenRequest);
            return json_decode($instance->getContent());
        } catch (Exception $e) {
            throw new BaseException('ERR_AUTHORIZATION_FAILED', 422, 'Username- '.$username.' '.$e->getMessage());
        }

    }
}
