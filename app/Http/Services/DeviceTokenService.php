<?php

namespace App\Http\Services;

use App\Models\DeviceToken;
use Carbon\Carbon;

class DeviceTokenService
{
    protected $user;
    protected $token;

    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    public function saveDeviceToken()
    {
        $date = Carbon::now()->setTimezone('Europe/Moscow');
        $deviceToken = DeviceToken::where(['user_id'=>$this->user->id, 'token'=>$this->token])->first();
        if($deviceToken){
            $deviceToken->created_at = $date;
            $deviceToken->save();
        }else{
            DeviceToken::create([
               'user_id'=>$this->user->id,
               'token'=>$this->token,
               'created_at'=>$date
            ]);
        }
    }

    public function deleteDeviceToken()
    {
        $deviceToken = DeviceToken::where(['user_id'=>$this->user->id, 'token'=>$this->token])->first();
        if($deviceToken){
            $deviceToken->delete();
        }
    }

}
