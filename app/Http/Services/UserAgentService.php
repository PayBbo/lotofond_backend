<?php

namespace App\Http\Services;

use App\Models\Notification;
use Carbon\Carbon;
use DeviceDetector\DeviceDetector;

class UserAgentService
{

    public function getUserAgent($userAgent, $user, $ip=null){

        $dd = new DeviceDetector($userAgent, null);
        $dd->parse();
        $clientInfo = $dd->getClient();
        $browser = null;
        $device =null;
        $osInfo = $dd->getOs();
        if(!is_null($osInfo)) {
            if (array_key_exists('name', $osInfo) && $osInfo['name']) {
                $device = 'OS '. $osInfo['name'];
                if (array_key_exists('version', $osInfo) && $osInfo['version']) {
                    $device .= ' ' . $osInfo['version'];
                }
            }
        }
        if($dd->isBrowser()){
            $browser = $clientInfo['name'] . ' '. $clientInfo['version'];
        }

        if($dd->isMobile()){
            $brand = $dd->getBrandName();
            if($brand){
                $device = $brand;
            }
            $model = $dd->getModel();
            if($model){
                $device .=' '.$model;
            }
        }
        $value = 'device is not defined';
        if(!is_null($device)){
            $value=$device;
        }
        if(!is_null($browser)){
            if(!is_null($device)) {
                $value .= ', ' . $browser;
            }else{
                $value=$browser;
            }
        }
        Notification::create([
            'user_id' => $user->id,
            'date' => Carbon::now()->setTimezone('Europe/Moscow'),
            'type_id' => 1,
            'message' => 'logInToYourAccountBody',
            'label' => 'logInToYourAccountTitle',
            'value'=>$value,
            'platform_action' => 'info'
        ]);



    }

    //метод для определения местоположения по ip

    public function ipInfo($ip = NULL, $purpose = "location", $deep_detect = TRUE)
    {
        $output = NULL;
        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
        $purpose = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
        $support = array("country", "countrycode", "state", "region", "city", "location", "address");
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case "location":
                        $output = array(
                            "city" => @$ipdat->geoplugin_city,
                            "state" => @$ipdat->geoplugin_regionName,
                            "country" => @$ipdat->geoplugin_countryName
                        );
                        break;
                    case "address":
                        $address = array($ipdat->geoplugin_countryName);
                        if (@strlen($ipdat->geoplugin_city) >= 1)
                            $address[] = $ipdat->geoplugin_city;
                        $output = implode(", ", array_reverse($address));
                        break;
                    case "city":
                        $output = @$ipdat->geoplugin_city;
                        break;
                    case "state":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "country":
                        $output = @$ipdat->geoplugin_countryName;
                        break;
                }
            }
        }
        return $output;
    }

}
