<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomExceptions\BaseException;
use App\Exports\FavouritePathExport;
use App\Http\Requests\FavouriteLotStoreRequest;
use App\Http\Requests\FavouriteLotUpdateRequest;
use App\Http\Requests\FavouritePathRequest;
use App\Http\Resources\ExportLotCollection;
use App\Http\Resources\ExportLotResource;
use App\Http\Resources\FavouritePathResource;
use App\Http\Resources\LotCollection;
use App\Models\Favourite;
use App\Models\Lot;
use App\Models\User;
use App\Rules\IsUserFavouritePath;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class FavouriteController extends Controller
{
    public function addEditFavouritePath(FavouritePathRequest $request)
    {
        if ($request->has('pathId') && !is_null($request->pathId)) {
            $path = Favourite::find($request->pathId);
            if ($path->title == 'Общее') {
                throw new BaseException("ERR_ACCESS_FORBIDDEN", 403, "The user does not have rights to edit the selected path");
            }

        } else {
            $user = User::find(auth()->id());
            $countFavouritePaths = $user->favourites->count();
            if($countFavouritePaths == 100){
                throw new BaseException("ERR_EXCEEDING_LIMIT", 422, __('validation.exceeding_limit'));
            }
            $path = new Favourite();
        }
        $path->user_id = auth()->id();
        $path->title = $request->name;
        $path->color = $request->color;
        $path->save();
        return response(null, 200);
    }

    public function deleteFavouritePath($id)
    {
        $path = Favourite::find($id);
        if (!$path || $path->user_id != auth()->id() || $path->title == 'Общее') {
            throw new BaseException("ERR_ACCESS_FORBIDDEN", 403, "The user does not have rights to edit the selected path");
        }
        $path->lots()->detach();
        $path->delete();
        return response(null, 200);
    }

    public function downloadFavouritePath(Request $request)
    {
        $this->validate($request, [
            'pathId' => ['required', 'numeric', 'exists:favourites,id', new IsUserFavouritePath()],
        ]);
        $path = Favourite::find($request->pathId);
        $headings = [];
        $request->request->remove('pathId');
        $conditions = [];
        foreach ($request->request as $key => $param) {
            if ($param) {
                $headings[] = __('exportExcel.' . lcfirst(substr($key, 3)));
            }
            $conditions[$key] = $param;
        }
        $collection = ExportLotResource::customCollection($path->lots, $conditions);
        $name = '/users/excel/user-' . auth()->id() . '/favourites.xlsx';
        $isSuccess = Excel::store(new FavouritePathExport($headings, $collection), $name);
        if($isSuccess){
            return response(['url'=>Storage::url($name)], 200);
        }else{
            throw new BaseException('ERR_FILE_UPLOAD', 422,  __('validation.export_err'));
        }

    }

    public function getFavourites(Request $request)
    {
        $request->validate([
            'pathId' => ['required', 'integer', new IsUserFavouritePath()]
        ]);
        $path = Favourite::find($request->pathId);
        $lots = $path->lots()->filterBy($request->request)->customSortBy($request)->paginate(20);
        return response(new LotCollection($lots), 200);

    }

    public function addLotsToFavourite(FavouriteLotStoreRequest $request)
    {
        if ($request->has('pathId')) {
            $path = Favourite::find($request->pathId);

        } elseif (!$request->has('pathId') && $request->has('name')) {
            $path = new Favourite();
            $path->user_id = auth()->id();
            $path->title = $request->name;
            $path->save();
        } else {
            $path = Favourite::where(['user_id' => auth()->id(), 'title' => 'Общее'])->first();
        }
        $lots = Lot::whereIn('id', $request->lots)->get();
        foreach ($lots as $lot) {
            if (!$path->lots->contains($lot)) {
                $path->lots()->attach($lot, ['created_at' => Carbon::now()]);
            }
        }
        return response(null, 200);
    }

    public function getFavouritePaths()
    {
        $favourites = Favourite::where('user_id', auth()->id())->orderBy('created_at', 'asc')->get();
        return response(FavouritePathResource::collection($favourites), 200);
    }

    public function deleteLotFromFavourite(Request $request)
    {
        $lot = Lot::find($request->lotId);
        if (!$lot) {
            throw new BaseException("ERR_FIND_LOT_FAILED", 404, "Lot with id= " . $request->lotId . ' does not exist');
        }
        if ($request->has('pathId')) {
            $path = Favourite::find($request->pathId);
            if (!$path || $path->user_id != auth()->id()) {
                throw new BaseException("ERR_ACCESS_FORBIDDEN", 403, "The user does not have rights to edit the selected path");
            }
            if ($path->lots->contains($lot)) {
                $path->lots()->detach($lot);
            }
        } else {
            $paths = Favourite::where('user_id', auth()->id())->get();
            foreach ($paths as $path) {
                if ($path->lots->contains($lot)) {
                    $path->lots()->detach($lot);
                }
            }
        }


        return response(null, 200);
    }

    public function moveLotInFavourite(FavouriteLotUpdateRequest $request)
    {

        $currentPath = Favourite::find($request->currentPathId);
        $newPath = Favourite::find($request->newPathId);
        $lot = Lot::find($request->lotId);
        if ($currentPath->lots->contains($lot)) {
            $currentPath->lots()->detach($lot);
        }
        if (!$newPath->lots->contains($lot)) {
            $newPath->lots()->attach($lot, ['created_at' => Carbon::now()]);
        }
        return response(null, 200);

    }
}
