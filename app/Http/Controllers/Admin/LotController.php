<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateLotRequest;
use App\Http\Resources\Admin\LotCollection;
use App\Http\Resources\Admin\ShortLotCollection;
use App\Http\Resources\Admin\UserResource;
use App\Http\Resources\Admin\LotResource;
use App\Http\Resources\PaginationResource;
use App\Models\Lot;
use Illuminate\Http\Request;

class LotController extends Controller
{

    /**
     * Проверка прав на совершение действий
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:lot-list', ['only' => ['get', 'show']]);
        $this->middleware('permission:lot-delete', ['only' => ['delete']]);
    }


    public function get(Request $request)
    {
        $searchString = $request->query('param');
        $lots = Lot::with((['auction', 'showRegions', 'status', 'lotImages', 'categories', 'lotParams']))
            ->when(isset($searchString) && strlen((string)$searchString) > 0, function ($query) use ($searchString) {
                $query->whereHas('auction', function ($q) use ($searchString) {
                    $q->where('trade_id', 'like', '%' . $searchString . '%');
                })
                    ->orWhere('description', 'like', '%' . $searchString . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        return response(new LotCollection($lots), 200);
    }

    public function show($id)
    {
        $lot = Lot::find($id);
        if ($lot) {
            $lot->isLotInfo = true;
            return response(new LotResource($lot), 200);
        }
        return response(null, 404);
    }

    public function delete($id){
        $lot = Lot::find($id);
        if ($lot) {
            $lot->delete();
        }
        return response(null, 200);
    }

    public function getShorts(Request $request){
        $searchString = $request->query('search');
        $lots = Lot::with('auction')
            ->when(isset($searchString) && strlen((string)$searchString) > 0, function ($query) use ($searchString) {
                $query->whereHas('auction', function ($q) use ($searchString) {
                    $q->where('trade_id', 'like', '%' . $searchString . '%');
                })
                    ->orWhere('description', 'like', '%' . $searchString . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return response(new ShortLotCollection($lots), 200);
    }
}
