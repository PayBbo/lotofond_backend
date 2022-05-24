<?php

namespace App\Http\Controllers;

use App\Http\Requests\MonitoringStoreRequest;
use App\Http\Requests\MonitoringUpdateRequest;
use App\Models\Monitoring;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $monitorings = Monitoring::all();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * @param \App\Http\Requests\MonitoringStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MonitoringStoreRequest $request)
    {
        $monitoring = Monitoring::create($request->validated());

    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Monitoring $monitoring
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Monitoring $monitoring)
    {

    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Monitoring $monitoring
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Monitoring $monitoring)
    {
    }

    /**
     * @param \App\Http\Requests\MonitoringUpdateRequest $request
     * @param \App\Models\Monitoring $monitoring
     * @return \Illuminate\Http\Response
     */
    public function update(MonitoringUpdateRequest $request, Monitoring $monitoring)
    {
        $monitoring->update($request->validated());

    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Monitoring $monitoring
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Monitoring $monitoring)
    {
        $monitoring->delete();
    }
}
