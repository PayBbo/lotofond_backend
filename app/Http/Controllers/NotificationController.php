<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationCollection;
use App\Models\Notification;
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
}
