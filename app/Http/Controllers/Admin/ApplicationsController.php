<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ApplicationCollection;
use App\Models\Application;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApplicationsController extends Controller
{
    public function get(Request $request){
        $search = $request->query('param');
        $applications = Application::when(isset($search), function($query) use ($search) {
            $query->where('type', 'LIKE', '%'.$search.'%')
                ->orWhere('email', 'LIKE', '%'.$search.'%')
                ->orWhere('username', 'LIKE', '%'.$search.'%')
                ->orWhere('phone', 'LIKE', '%'.$search.'%')
                ->orWhere('topic', 'LIKE', '%'.$search.'%')
                ->orWhere('question', 'LIKE', '%'.$search.'%');
        })->paginate(20);
        return response(new ApplicationCollection($applications), 200);
    }

    public function update(Request $request){
        $application = Application::find($request->id);
        if($application){
            if(!$application->is_answered && !is_null($application->user_id)){
                Notification::create([
                    'user_id' => $application->user_id,
                    'date' => Carbon::now()->setTimezone('Europe/Moscow'),
                    'label'=>'applicationAnswerTitle',
                    'type_id' => 1,
                    'message' =>  'applicationAnswerBody',
                ]);
            }
            $application->is_answered = !$application->is_answered;
            $application->save();
            return response(null, 200);
        }
        return response(null, 404);
    }
}
