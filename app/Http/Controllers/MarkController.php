<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarkStoreRequest;
use App\Http\Requests\MarkUpdateRequest;
use App\Models\Mark;
use Illuminate\Http\Request;

class MarkController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $marks = Mark::all();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * @param \App\Http\Requests\MarkStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MarkStoreRequest $request)
    {
        $mark = Mark::create($request->validated());
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Mark $mark
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Mark $mark)
    {

    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Mark $mark
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Mark $mark)
    {
    }

    /**
     * @param \App\Http\Requests\MarkUpdateRequest $request
     * @param \App\Models\Mark $mark
     * @return \Illuminate\Http\Response
     */
    public function update(MarkUpdateRequest $request, Mark $mark)
    {
        $mark->update($request->validated());

    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Mark $mark
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Mark $mark)
    {
        $mark->delete();
    }
}
