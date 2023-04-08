<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HolidayAddRequest;
use App\Http\Resources\Admin\HolidayCollection;
use App\Http\Resources\PaginationResource;
use App\Models\HolidayDate;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HolidayDayController extends Controller
{
    /**
     * Проверка прав на совершение действий
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:holidays-list', ['only' => ['get']]);
        $this->middleware('permission:holidays-add', ['only' => ['add']]);
        $this->middleware('permission:holidays-delete', ['only' => ['delete']]);
    }

    public function get(Request $request)
    {
        $searchString = $request->query('param');
        $sortParam = $request->query('sort_property');
        $sortDirection = $request->query('sort_direction');
        if ($searchString === "null") {
            $searchString = null;
        }
        if(!is_null($searchString)){
            $searchString = Carbon::parse($searchString)->format('Y-m-d');
        }
        $holidays = HolidayDate::when(!is_null($searchString), function ($query) use ($searchString) {
            $query->where('date', 'LIKE', '%'.$searchString.'%');
        })
            ->when(isset($sortParam) && isset($sortDirection), function ($query) use ($sortParam, $sortDirection) {
                $query->orderBy($sortParam, $sortDirection);
            })
            ->paginate(20);
        return response(new HolidayCollection($holidays),  200);
    }

    public function add(HolidayAddRequest $request)
    {
        HolidayDate::create([
            'date' => Carbon::parse($request->date)
        ]);
        return response(null, 200);
    }

    public function delete($id)
    {
        $holiday = HolidayDate::find($id);
        if (!$holiday) {
            return response(null, 404);
        }
        $holiday->delete();
        return response(null, 200);
    }
}
