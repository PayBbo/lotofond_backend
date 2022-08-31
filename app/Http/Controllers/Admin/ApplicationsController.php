<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ApplicationCollection;
use App\Models\Application;
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
            $application->is_answered = !$application->is_answered;
            $application->save();
            return response(null, 200);
        }
        return response(null, 404);
    }
}
