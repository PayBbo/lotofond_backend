<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateLotRequest;
use App\Http\Resources\Admin\LotCollection;
use App\Http\Resources\Admin\ShortLotCollection;
use App\Http\Resources\Admin\UserResource;
use App\Http\Resources\Admin\LotResource;
use App\Http\Resources\PaginationResource;
use App\Http\Services\Parse\DescriptionExtractsService;
use App\Http\Services\Parse\ParseDataFromRosreestrService;
use App\Models\Lot;
use App\Models\LotParam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        try {
            ini_set('max_execution_time', 6000);
            $searchString = $request->query('param');
            $sortParam = $request->query('sort_property');
            $sortDirection = $request->query('sort_direction');
            $response = DB::table('lots')->select([
                'lots.*',
                DB::raw('DATE_FORMAT(ifnull(auction.publish_date,lots.created_at), "%d.%m.%Y, %H:%i") as publishDate'),
//                'auction.publish_date as publishDate',
                'auction.trade_id as tradeNumber',
                'type.title as tradeType',
                'status.value as status',
                'ali.is_moderated as additionalLotInfoIsModerated',
                'ali.id as additionalLotInfoId',
                'ali.message as additional_lot_info_message',
                'lots.start_price as startPrice',
            ])
                ->when(isset($searchString) && strlen((string)$searchString) > 0, function ($query) use ($searchString) {
                    $query->where('auction.trade_id', 'like', '%' . $searchString . '%')
                        ->orWhere('lots.description', 'like', '%' . $searchString . '%')
                        ->orWhere('lots.id', 'like', '%' . $searchString . '%');
                })
                ->leftJoin('auctions as auction', 'auction.id', '=', 'lots.auction_id')
                ->leftJoin('auction_types as type', 'auction.auction_type_id', '=', 'type.id')
                ->leftJoin('statuses as status', 'status.id', '=', 'lots.status_id')
                ->leftJoin('additional_lot_infos as ali', 'ali.lot_id', '=', 'lots.id')
                ->when(isset($sortParam) && isset($sortDirection), function ($query) use ($sortParam, $sortDirection) {
                    $query->orderBy($sortParam, $sortDirection);
                })
                ->paginate(20);
            return response([
                'data' => $response->items(),
                'pagination' => new PaginationResource($response)
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }

    public function show($id)
    {
        try {
            $lot = Lot::find($id);
            if ($lot) {
                $lot->isLotInfo = true;
                return response(new LotResource($lot), 200);
            }
            return response(null, 404);
        }
        catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

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

    public function updateCadastralNumberInfo() {
        try {
            $lotId = request()->get("id");
            $number = request()->get("cadastralNumber");
            $lot = Lot::find($lotId);
            $categories = null;
            if($lot) {
                $categories = $lot->categories()->get();
            }
            $parseDataFromRosreestr = new ParseDataFromRosreestrService($number, $lotId, $categories);
            $response = $parseDataFromRosreestr->handle();
            return response()->json(['result' => $response], 200);
        }
        catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function updateCadastralInfo() {
        try {
            $lot = Lot::find(request()->get("id"));
            if($lot) {
                $description = $lot->description;
                $descriptionExtracts = new DescriptionExtractsService();
                $descriptionExtracts->getCadastralNumbers($lot, $description);
                return response()->json(['result' => true], 200);
            }
            return response()->json(['message' => 'Такой лот не найден'], 500);
        }
        catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function deleteParam($id) {
        $param = LotParam::find($id);
        if($param) {
            if($param->parent_id===null) {
                LotParam::where('parent_id', $param->id)->delete();
            }
            $param->delete();
            return response()->json(['message' => 'Параметр успешно удален', 'result'=> true], 200);
        }
        return response()->json(['message' => 'Такой параметр не найден'], 500);
    }
}
