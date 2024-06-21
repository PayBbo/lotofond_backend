<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddEditTariffRequest;
use App\Http\Resources\Admin\TariffResource;
use App\Models\Tariff;
use Illuminate\Http\Request;

class TariffController extends Controller
{

    /**
     * Проверка прав на совершение действий
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:tariff-list', ['only' => ['get']]);
        $this->middleware('permission:tariff-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:tariff-add', ['only' => ['add']]);
        $this->middleware('permission:tariff-delete', ['only' => ['delete']]);
    }

    public function get(Request $request)
    {
        $sortParam = $request->query('sort_property');
        $sortDirection = $request->query('sort_direction');
        $tariffs = Tariff::whereIn('type', ['tariff', 'service'])
            ->when(isset($sortParam) && isset($sortDirection), function ($query) use ($sortParam, $sortDirection) {
                $query->orderBy($sortParam, $sortDirection);
            })
            ->get();
        return response(['data'=>TariffResource::collection($tariffs), 'pagination'=>[]], 200);
    }

    public function add(AddEditTariffRequest $request)
    {
        $tariff = new Tariff();
        $tariff->title = $request->title;
        $tariff->description = $request->description;
        $tariff->price = $request->price;
        $tariff->period = $request->period;
        $tariff->included_details = $request->includedDetails;
        $tariff->excluded_details = $request->excludedDetails;
        $tariff->type = 'tariff';
        $tariff->save();
        return response(null, 200);
    }

    public function edit($id)
    {
        $tariff = Tariff::find($id);
        if ($tariff) {
            return response(new TariffResource($tariff), 200);
        }
        return response(null, 404);
    }

    public function update(AddEditTariffRequest $request)
    {
        $tariff = Tariff::find($request->id);
        if ($tariff) {
            $tariff->title = $request->title;
            $tariff->description = $request->description;
            $tariff->price = $request->price;
            $tariff->period = $request->period;
            $tariff->included_details = $request->includedDetails;
            $tariff->excluded_details = $request->excludedDetails;
            $tariff->active = isset($request->active) ? $request->active : $tariff->active;
            $tariff->save();
            return response(null, 200);
        }
        return response(null, 404);
    }

    public function delete($id)
    {
        $tariff = Tariff::find($id);
        if ($tariff) {
            $tariff->delete();
            return response(null, 200);
        }
        return response(null, 404);
    }

    public function changeStatus($id)
    {
        $tariff = Tariff::find($id);
        if ($tariff) {
            $tariff->active = !$tariff->active;
            $tariff->save();
            return response(null, 200);
        }
        return response(null, 404);
    }
}
