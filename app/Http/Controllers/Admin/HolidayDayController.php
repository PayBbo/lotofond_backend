<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HolidayAddRequest;
use App\Models\HolidayDate;
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
        $holidays = HolidayDate::when(isset($searchString), function ($query) use ($searchString) {
            $query->where('date', $searchString);
        })->select('id', 'date')->paginate(20);
        return response($holidays, 200);
    }

    public function add(HolidayAddRequest $request)
    {
        HolidayDate::create([
            'date' => $request->date
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
