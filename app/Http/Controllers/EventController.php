<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventStoreRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Http\Resources\EventCollection;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Rules\IsUserEvent;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function getEvents(Request $request){
        if($request->type == 'all'){
            $events = Event::where('user_id', auth()->id())
                ->whereMonth('date', $request->month)
                ->whereYear('date', $request->year)
                ->get();
        }else{
            $events = Event::where(['user_id'=> auth()->id(), 'event_type'=>$request->type])
                ->whereMonth('date', $request->month)
                ->whereYear('date', $request->year)
                ->get();
        }
        return response(new EventCollection($events), 200);
    }

    public function addEvent(EventStoreRequest $request){
        $event = Event::create([
            'date'=>$request->date,
            'time'=>$request->time,
            'title'=>$request->title,
            'event_type'=>$request->type,
            'user_id'=>auth()->id()
        ]);

        return response(new EventResource($event), 200);
    }

    public function editEvent(EventUpdateRequest $request){
        $event = Event::find($request->id);
        $event->date = $request->date;
        $event->time = $request->time;
        $event->title = $request->title;
        $event->event_type = $request->type;
        $event->save();
        return response(new EventResource($event), 200);
    }

    public function deleteEvent(Request $request){
        $request->validate([
            'id' => ['required', 'integer', 'exists:events,id', new IsUserEvent()]
        ]);
        $event = Event::find($request->id);
        $event->delete();
        return response(null, 200);
    }
}
