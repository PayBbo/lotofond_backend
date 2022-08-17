<?php

namespace App\Http\Services;

use App\Models\User;
use Carbon\Carbon;

class PushNotificationService
{
    protected $title;
    protected $body;
    protected $user_id;

    public function __construct($title, $body, $user_id){
        $this->title = $title;
        $this->body = $body;
        $this->user_id = $user_id;
    }

    public function sendPushNotification(){
        $user = User::find($this->user_id);
        $date = Carbon::now()->setTimezone('Europe/Moscow');
        $tokens = $user->deviceTokens->where('created_at', '<', $date->subMonths(2))->pluck('token')->toArray();
        if(count($tokens)>0) {
            try {
                $SERVER_API_KEY = config('larafirebase.authentication_key');

                $data = [
                    "registration_ids" => $tokens,
                    "notification" => [
                        "title" => $this->title,
                        "body" => $this->body,
                    ]
                ];
                $dataString = json_encode($data);

                $headers = [
                    'Authorization: key=' . $SERVER_API_KEY,
                    'Content-Type: application/json',
                ];

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

                $response = curl_exec($ch);
                curl_close($ch);
            }catch(\Exception $e){
                logger($e);
            }
        }
    }

}
