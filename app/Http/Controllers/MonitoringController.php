<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Requests\MonitoringPathRequest;
use App\Http\Resources\LotCollection;
use App\Http\Resources\MonitoringPathResource;
use App\Models\Lot;
use App\Models\Monitoring;
use App\Rules\IsUserMonitoringPath;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
   public function addEditMonitoringPath(MonitoringPathRequest $request){
       if ($request->has('pathId')) {
           $path = Monitoring::find($request->pathId);
       } else {
           $path = new Monitoring();
       }
       $path->user_id = auth()->id();
       $path->title = $request->name;
       $path->color = $request->color;
       $path->not_time = $request->notificationTime;
       $path->filters = $request->filters;
       $path->save();
       $lots = Lot::filterBy($request->filters)->get();
       if($lots->count() >0) {
           foreach ($lots as $lot) {
               if (!$path->lots->contains($lot)) {
                   $path->lots()->attach($lot);
               }
           }
       }
       return response(null, 200);
   }

    public function deleteMonitoringPath($id){
        $path = Monitoring::find($id);
        if (!$path || $path->user_id != auth()->id()) {
            throw new BaseException("ERR_ACCESS_FORBIDDEN", 403, "The user does not have rights to edit the selected path");
        }
        $path->lots()->detach();
        $path->delete();
        return response(null, 200);
    }

    public function getMonitoringLots(Request $request){
        $request->validate([
            'pathId'=>['required', 'integer', new IsUserMonitoringPath()]
        ]);
        $path = Monitoring::find($request->pathId);
        $lots = $path->lots()->filterBy($request->request)->customSortBy($request)->paginate(20);
        return response(new LotCollection($lots), 200);
    }

    public function getMonitoringPaths(){
        $monitorings = Monitoring::where('user_id', auth()->id())->orderBy('created_at', 'asc')->get();
        return response(MonitoringPathResource::collection($monitorings), 200);
    }

    public function deleteLotFromMonitoring($pathId, $lotId){
        $path = Monitoring::find($pathId);
        $lot = Lot::find($lotId);
        if (!$path || !$lot || $path->user_id != auth()->id()) {
            throw new BaseException("ERR_ACCESS_FORBIDDEN", 403, "The user does not have rights to edit the selected path");
        }
        if ($path->lots->contains($lot)) {
            $path->lots()->detach($lot);
        }

        return response(null, 200);
    }

}
