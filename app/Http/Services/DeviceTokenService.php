<?php

namespace App\Http\Services;

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
        if (!is_null($this->user->device_tokens)) {
            $not_tokens = $this->user->device_tokens;
            if (!in_array($this->token, $not_tokens)) {
                $not_tokens[] = $this->token;
            }

        } else {
            $not_tokens[] = $this->token;
        }
        $this->user->device_tokens = $not_tokens;
        $this->user->save();
    }

    public function deleteDeviceToken()
    {
        $not_tokens = $this->user->device_tokens;
        if (in_array($this->token, $not_tokens)) {
            $array = array_flip($not_tokens);
            unset ($array[$this->token]);
            $not_tokens = null;
            foreach (array_flip($array) as $item) {
                $not_tokens[] = (string)$item;
            }
        }

        $this->user->device_tokens = $not_tokens;

        $this->user->save();
    }

}
