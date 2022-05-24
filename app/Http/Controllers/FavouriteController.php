<?php

namespace App\Http\Controllers;

use App\Http\Requests\FavouriteStoreRequest;
use App\Http\Requests\FavouriteUpdateRequest;
use App\Models\Favourite;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $favourites = Favourite::all();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * @param \App\Http\Requests\FavouriteStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FavouriteStoreRequest $request)
    {
        $favourite = Favourite::create($request->validated());

    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Favourite $favourite
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Favourite $favourite)
    {
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Favourite $favourite
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Favourite $favourite)
    {
    }

    /**
     * @param \App\Http\Requests\FavouriteUpdateRequest $request
     * @param \App\Models\Favourite $favourite
     * @return \Illuminate\Http\Response
     */
    public function update(FavouriteUpdateRequest $request, Favourite $favourite)
    {
        $favourite->update($request->validated());

    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Favourite $favourite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Favourite $favourite)
    {
        $favourite->delete();
    }
}
