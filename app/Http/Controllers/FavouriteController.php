<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Requests\FavouriteLotStoreRequest;
use App\Http\Requests\FavouriteLotUpdateRequest;
use App\Http\Requests\FavouritePathRequest;
use App\Http\Resources\FavouritePathResource;
use App\Http\Resources\LotCollection;
use App\Models\Favourite;
use App\Models\Lot;
use App\Rules\IsUserFavouritePath;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    public function addEditFavouritePath(FavouritePathRequest $request)
    {
        if ($request->has('pathId')) {
            $path = Favourite::find($request->pathId);
            if ($path->title == 'Общее') {
                throw new BaseException("ERR_ACCESS_FORBIDDEN", 403, "The user does not have rights to edit the selected path");
            }

        } else {
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

    }

    public function getFavourites(Request $request)
    {
        $request->validate([
            'pathId'=>['required', 'integer', new IsUserFavouritePath()]
        ]);
        $path = Favourite::find($request->pathId);
        $lots = $path->lots()->filterBy($request->request)->customSortBy($request)->paginate(20);
        return response(new LotCollection($lots), 200);

    }

    public function addLotsToFavourite(FavouriteLotStoreRequest $request)
    {
        if ($request->has('pathId')) {
            $path = Favourite::find($request->pathId);

        } else {
            $path = new Favourite();
            $path->user_id = auth()->id();
            $path->title = $request->name;
            $path->save();
        }
        $lots = Lot::whereIn('id', $request->lots)->get();
        foreach ($lots as $lot) {
            if (!$path->lots->contains($lot)) {
                $path->lots()->attach($lot, ['created_at'=>Carbon::now()]);
            }
        }
        return response(null, 200);
    }

    public function getFavouritePaths()
    {
        $favourites = Favourite::where('user_id', auth()->id())->orderBy('created_at', 'asc')->get();
        return response(FavouritePathResource::collection($favourites), 200);
    }

    public function deleteLotFromFavourite($pathId, $lotId)
    {
        $path = Favourite::find($pathId);
        $lot = Lot::find($lotId);
        if (!$path || !$lot || $path->user_id != auth()->id()) {
            throw new BaseException("ERR_ACCESS_FORBIDDEN", 403, "The user does not have rights to edit the selected path");
        }
        if ($path->lots->contains($lot)) {
            $path->lots()->detach($lot);
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
            $newPath->lots()->attach($lot, ['created_at'=>Carbon::now()]);
        }
        return response(null, 200);

    }
}
