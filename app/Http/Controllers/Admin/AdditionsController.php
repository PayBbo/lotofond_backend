<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddEditAdditionRequest;
use App\Http\Resources\Admin\AdditionsCollection;
use App\Http\Resources\Admin\AdditionsResource;
use App\Models\AdditionalLotInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdditionsController extends Controller
{

    /**
     * Проверка прав на совершение действий
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:additions-list', ['only' => ['get']]);
        $this->middleware('permission:additions-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:additions-add', ['only' => ['add']]);
        $this->middleware('permission:additions-delete', ['only' => ['delete']]);
    }

    public function get(Request $request)
    {
        $search = json_decode($request->query('param'), true) ?? [];
        $isModerated = array_key_exists('isModerated', $search) ? $search['isModerated'] : false;
        $date =array_key_exists('date', $search) ? $search['date'] : null;
        $sortParam = $request->query('sort_property');
        $sortDirection = $request->query('sort_direction');
        $additions = AdditionalLotInfo::when($isModerated, function ($query) {
            $query->where('is_moderated', false);
        })
            ->when(!is_null($date), function ($query) use ($date) {
                $query->whereDate('created_at', $date);
            })
            ->withCount('files')
            ->when(isset($sortParam) && isset($sortDirection), function ($query) use ($sortParam, $sortDirection) {
                $query->orderBy($sortParam, $sortDirection);
            })
            ->paginate(20);
        return response(new AdditionsCollection($additions), 200);
    }

    public function edit($id)
    {
        $addition = AdditionalLotInfo::find($id);
        if (!$addition) {
            return response(null, 404);
        }
        return response(new AdditionsResource($addition), 200);
    }

    public function add(AddEditAdditionRequest $request)
    {
        $addition = new AdditionalLotInfo();
        $addition->lot_id = $request->lotId;
        $addition->message = $request->message;
        $addition->is_moderated = $request->isModerated;
        $addition->save();
        return response(null, 200);

    }

    public function update(AddEditAdditionRequest $request)
    {
        $addition = AdditionalLotInfo::find($request->id);
        if(!$addition){
            return response(null, 404);
        }
        $addition->message = $request->message;
        $addition->is_moderated = $request->isModerated;
        $addition->save();
        return response(null, 200);

    }

    public function changeStatus($id){
        $addition = AdditionalLotInfo::find($id);
        if($addition){
            $addition->is_moderated = !$addition->is_moderated;
            $addition->save();
            return response(null, 200);
        }
        return response(null, 404);
    }

    public function delete($id)
    {
        $addition = AdditionalLotInfo::find($id);
        if (!$addition) {
            return response(null, 404);
        }
        $addition->delete();
        return response(null, 200);
    }


}
