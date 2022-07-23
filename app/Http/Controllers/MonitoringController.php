<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Requests\MonitoringPathRequest;
use App\Http\Resources\LotCollection;
use App\Http\Resources\MonitoringPathResource;
use App\Models\Lot;
use App\Models\Monitoring;
use App\Models\User;
use App\Rules\IsUserMonitoringPath;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
   public function addEditMonitoringPath(MonitoringPathRequest $request){
       if ($request->has('pathId') && !is_null($request->pathId)) {
           $path = Monitoring::find($request->pathId);
       } else {
           $user = User::find(auth()->id());
           $countMonitoringPaths = $user->monitorings->count();
           if($countMonitoringPaths == 100){
               throw new BaseException("ERR_EXCEEDING_LIMIT", 422, __('validation.exceeding_limit'));
           }
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

    public function deleteLotFromMonitoring(Request $request){
        $lot = Lot::find($request->lotId);
        if (!$lot) {
            throw new BaseException("ERR_FIND_LOT_FAILED", 404, "Lot with id= " . $request->lotId . ' does not exist');
        }
        if($request->has('pathId')) {
            $path = Monitoring::find($request->pathId);
            if (!$path || $path->user_id != auth()->id()) {
                throw new BaseException("ERR_ACCESS_FORBIDDEN", 403, "The user does not have rights to edit the selected path");
            }
            if ($path->lots->contains($lot)) {
                $path->lots()->detach($lot);
            }
        }else{
            $paths = Monitoring::where('user_id', auth()->id())->get();
            foreach($paths as $path){
                if ($path->lots->contains($lot)) {
                    $path->lots()->detach($lot);
                }
            }
        }

        return response(null, 200);
    }

}
