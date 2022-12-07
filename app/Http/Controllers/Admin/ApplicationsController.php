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
    /**
     * Проверка прав на совершение действий
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:application-list', ['only' => ['get']]);
        $this->middleware('permission:application-edit', ['only' => ['update']]);
    }

    public function get(Request $request)
    {
        $search = $request->query('param');
        $applications = Application::when(isset($search), function ($query) use ($search) {
            $query
                ->whereHas('tariff', function ($query) use ($search) {
                    $query->where('title', 'LIKE', '%' . $search . '%');
                })
                ->orWhere('email', 'LIKE', '%' . $search . '%')
                ->orWhere('username', 'LIKE', '%' . $search . '%')
                ->orWhere('phone', 'LIKE', '%' . $search . '%')
                ->orWhere('topic', 'LIKE', '%' . $search . '%')
                ->orWhere('question', 'LIKE', '%' . $search . '%');
        })->paginate(20);
        return response(new ApplicationCollection($applications), 200);
    }

    public function update(Request $request)
    {
        $application = Application::find($request->id);
        if ($application) {
            $application->status = $request->status;
            $application->save();
            return response(null, 200);
        }
        return response(null, 404);
    }
}
