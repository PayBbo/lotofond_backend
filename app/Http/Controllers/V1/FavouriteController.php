<?php

namespace App\Http\Controllers\V1;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\FavouriteLotStoreRequest;
use App\Jobs\AddFavouriteEventsJob;
use App\Models\Favourite;
use App\Models\Lot;
use App\Models\User;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    public function addLotsToFavourite(FavouriteLotStoreRequest $request)
    {
        $user = User::find(auth()->id());
        if(is_null($user->email)){
            throw new BaseException("ERR_EMAIL_REQUIRED", 409, __('validation.required', ['attribute'=>'email']));
        }
        if ($request->has('pathId')) {
            $path = Favourite::find($request->pathId);

        } elseif (!$request->has('pathId') && $request->has('name')) {
            $path = new Favourite();
            $path->user_id = auth()->id();
            $path->title = $request->name;
            $path->save();
        } else {
            $path = Favourite::where(['user_id' => auth()->id(), 'main' => true])->first();
        }
        $lots = Lot::whereIn('id', $request->lots)->get();
        dispatch((new AddFavouriteEventsJob($lots, $user, $path))->onQueue('user'));
        return response(null, 200);
    }
}
