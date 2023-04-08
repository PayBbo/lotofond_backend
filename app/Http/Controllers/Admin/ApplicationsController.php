<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ApplicationCollection;
use App\Http\Resources\Admin\ApplicationResource;
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
        $sortParam = $request->query('sort_property');
        $sortDirection = $request->query('sort_direction');
        $applications = Application::when(isset($search), function ($query) use ($search) {
            $query->where('email', 'LIKE', '%' . $search . '%')
                ->orWhere('username', 'LIKE', '%' . $search . '%')
                ->orWhere('phone', 'LIKE', '%' . $search . '%')
                ->orWhere('topic', 'LIKE', '%' . $search . '%')
                ->orWhere('question', 'LIKE', '%' . $search . '%')
                ->orWhere('cadastral_number', 'LIKE', '%' . $search . '%');
        })
            ->leftJoin('tariffs as tariff', 'tariff.id', '=', 'applications.tariff_id')
            ->select('applications.*', 'tariff.title->ru as type')
            ->when(isset($sortParam) && isset($sortDirection), function ($query) use ($sortParam, $sortDirection) {
                $query->orderBy($sortParam, $sortDirection);
            })
            ->paginate(20);
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

    public function show($id)
    {
        $application = Application::where('id', $id)
            ->leftJoin('tariffs as tariff', 'tariff.id', '=', 'applications.tariff_id')
            ->select('applications.*', 'tariff.title->ru as type')
            ->first();
        if (!$application) {
            return response(null, 404);
        }
        return response(new ApplicationResource($application), 200);
    }
}
