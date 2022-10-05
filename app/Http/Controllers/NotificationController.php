<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Resources\NotificationCollection;
use App\Http\Services\PushNotificationService;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNotifications($type){
        if($type == 'all'){
            $notifications = Notification::where('user_id', auth()->id())->orderBy('is_seen', 'asc')->orderBy('date', 'desc')->paginate(20);
        }else{
            $notifications = Notification::where('user_id', auth()->id())
                ->whereHas('type', function ($q) use ($type) {
                $q->where('title', $type);
                })
                ->orderBy('is_seen', 'asc')
                ->orderBy('date', 'desc')
                ->paginate(20);
        }
        return response(new NotificationCollection($notifications), 200);
    }

    public function makeNotificationsSeen(Request $request){

        $notifications = Notification::whereIn('id', $request->notificationIds)->where('user_id',auth()->id())->get();
        foreach($notifications as $notification){
            $notification->is_seen = true;
            $notification->save();
        }
        return response(null, 200);
    }

    public function makeSeenAllNotificationsByType($type){
        if($type == 'all'){
            $notifications = Notification::where(['user_id' => auth()->id(), 'is_seen' => false])->get();
        }else {
            $notifications = Notification::where(['user_id' => auth()->id(), 'is_seen' => false])
                ->whereHas('type', function ($q) use ($type) {
                    $q->where('title', $type);
                })->get();
        }
        foreach($notifications as $notification){
            $notification->is_seen = true;
            $notification->save();
        }
        return response(null, 200);
    }

    public function countNotificationsByType($type){
        if($type == 'all'){
            $count = Notification::where(['user_id'=> auth()->id(), 'is_seen'=>false])->count();
        }else{
            $count = Notification::where(['user_id'=> auth()->id(), 'is_seen'=>false])
                ->whereHas('type', function ($q) use ($type) {
                    $q->where('title', $type);
                })
                ->count();
        }
        return response(['count'=>$count], 200);
    }

    public function testNots(){
        try {
            $nots = ['favourite', 'monitoring', 'favourite', 'monitoring', 'favourite', 'monitoring', 'favourite', 'monitoring', 'favourite', 'monitoring'];
            foreach ($nots as $not) {
                if ($not == 'favourite') {
                    Notification::create([
                        'user_id' => 17,
                        'lot_id' => 100,
                        'date' => Carbon::now()->setTimezone('Europe/Moscow'),
                        'type_id' => 2,
                        'value' => Carbon::now()->setTimezone('Europe/Moscow')->format('d.m.y H:i'),
                        'message' => 'favouriteApplicationEnd'
                    ]);
                } else {
                    $notification = Notification::create([
                        'user_id' => 17,
                        'date' => Carbon::now()->setTimezone('Europe/Moscow'),
                        'type_id' => 3,
                        'value' => 20,
                        'monitoring_id' => 51,
                        'message' => 'monitoring'
                    ]);
                    $title = $notification->monitoring->title;
                    $value = __('messages.' . $notification->message, ['value' => $notification->value]);
                    $push = new PushNotificationService($title, $value, $notification->user_id, $notification->type->title);
                    $push->sendPushNotification();
                }
            }
            return response(null, 200);
        }catch (\Exception $exception){
            throw new BaseException("ERR_NOTIFICATION_SEND", 500, $exception);
        }
    }
}
