<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TextDataRequest;
use App\Http\Resources\Admin\TextDataCollection;
use App\Http\Resources\TextDataResource;
use App\Models\TextData;
use Illuminate\Http\Request;

class TextDataController extends Controller
{

    /**
     * Проверка прав на совершение действий
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:text-data-list', ['only' => ['get']]);
        $this->middleware('permission:text-data-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:text-data-add', ['only' => ['add']]);
        $this->middleware('permission:text-data-delete', ['only' => ['delete']]);
    }


    public function get(Request $request)
    {
        $sortParam = $request->query('sort_property');
        $sortDirection = $request->query('sort_direction');
        $type = $request->query('param');
        $items = TextData::where('type', $type)
            ->when(isset($sortParam) && isset($sortDirection), function ($query) use ($sortParam, $sortDirection) {
                $query->orderBy($sortParam, $sortDirection);
            })
            ->paginate(20);
        return response(new TextDataCollection($items), 200);
    }

    public function add(TextDataRequest $request)
    {
        $textData = new TextData();
        $textData->header = $request->header;
        $textData->value = $request->value;
        $textData->type = $request->type;
        $textData->screen = $request->screen;
        $textData->save();
        return response(null, 200);

    }

    public function update(TextDataRequest $request)
    {
        $textData = TextData::find($request->id);
        if ($textData) {
            $textData->header = $request->header;
            $textData->value = $request->value;
            if($textData->type == 'buyBlock') {
                $textData->points = $request->points;
            }
            $textData->save();
            return response(null, 200);
        }
        return response(null, 404);
    }

    public function edit($id)
    {
        $textData = TextData::find($id);
        if ($textData) {
            return response(new TextDataResource($textData), 200);
        }
        return response(null, 404);
    }

    public function delete($id)
    {
        $textData = TextData::find($id);
        if ($textData) {
            $textData->delete();
            return response(null, 200);
        }
        return response(null, 404);
    }
}
