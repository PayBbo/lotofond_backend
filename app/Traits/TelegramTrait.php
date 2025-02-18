<?php

namespace App\Traits;

use App\Http\Services\DeviceTokenService;
use App\Http\Services\GenerateAccessTokenService;
use App\Models\Region;
use App\Models\SocialAccount;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Hash;

trait TelegramTrait
{
    public function validateTGData($auth_data, $bot_token) {

        parse_str($auth_data, $arr);

        $check_hash = $arr['hash'];
        unset($arr['hash']);
        ksort($arr);
        $data_str = "";
        foreach($arr as $k=>$v) {
            $data_str .= $k."=".$v."\x0A";
        }
        $data_str = trim($data_str);

        $secret = hash_hmac('sha256', $bot_token, 'WebAppData', true);
        $hash = hash_hmac('sha256', $data_str, $secret);

        return strcmp($hash, $check_hash) === 0;
    }

    public function checkTelegramAuthorization($auth_data, $bot_token) {
        $check_hash = $auth_data['hash'];
        unset($auth_data['hash']);

        if(is_array($auth_data['user'])) {
            $auth_data['user'] = json_encode($auth_data['user'], JSON_UNESCAPED_UNICODE);
            $auth_data['user'] = str_replace('null', '""', $auth_data['user']);
        }

        $data_check_arr = [];
        foreach ($auth_data as $key => $value) {
            $data_check_arr[] = $key . '=' . $value;
        }
        sort($data_check_arr);
        $data_check_string = implode("\x0A", $data_check_arr);

        $secret_key = hash_hmac('sha256', $bot_token, 'WebAppData', true);
        $hash = hash_hmac('sha256', $data_check_string, $secret_key);
        $result = strcmp($hash, $check_hash);
        if (strcmp($hash, $check_hash) !== 0) {
            throw new Exception('Data is NOT from Telegram');
        }
        if ((time() - $auth_data['auth_date']) > 86400)
            throw new Exception('Data is outdated');
        return $result === 0;
    }

    public function addNewTelegramUser($userData, $password) {
        $regionId = null;
        if($userData->region) {
            $region = Region::where('code',$userData->region)->first();
            if($region) {
                $regionId = $region->id;
            }
        }

        $user = User::create([
            'tg_id' => $userData->id,
            'tg_username' => $userData->username ?: null,
            'name' => $userData->first_name ?: null,
            'surname' => $userData->last_name ?: null,
            'region_id' => $regionId,
            'email' => $userData->email ?: null,
            'phone' => $userData->phone ?: null,
            'password' => Hash::make($password),
            'email_verified_at' => null,
            'tg_connected_at' => Carbon::now()->setTimezone('Europe/Moscow'),
            'not_settings' => [
                'favouriteEventStart' => 1,
                'favouriteEventEnd' => 1,
                'favouriteApplicationStart' => 1,
                'favouriteApplicationEnd' => 1,
                'favouriteResult' => 1,
                'favouritePriceReduction' => 1
            ]
        ]);
        return $user;
    }

}
