<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Controllers\Controller;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    public function appleCallback(Request $request)
    {
        $code = $request['code'];
        $clientId = config('socials.apple_client_id');
        $clientSecret = config('socials.apple_client_secret');
        try {
            $client = new Client();
            $response = $client->request('POST', 'https://appleid.apple.com/auth/token', ['form_params' => [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'code' => $code,
                'grant_type' => 'authorization_code'
            ]]);

            $content = json_decode($response->getBody(), true);
            $idToken = $content['id_token'];
            return redirect("intent://callback?".$request->getContent()."#Intent;package=ru.nikahtime;scheme=signinwithapple;end");
        } catch (Exception $e) {
            throw new BaseException('ERR_AUTHORIZATION_FAILED', 422, 'Code - '.$code.' '. $e->getMessage());
        }
    }
}
