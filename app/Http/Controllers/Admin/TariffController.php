<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\TariffResource;
use App\Models\Tariff;
use Illuminate\Http\Request;

class TariffController extends Controller
{

    /**
     * Проверка прав на совершение действий
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:tariff-list', ['only' => ['get']]);
        $this->middleware('permission:tariff-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:tariff-add', ['only' => ['add']]);
        $this->middleware('permission:tariff-delete', ['only' => ['delete']]);
    }

    public function get()
    {
        $tariffs = Tariff::all();
        return response(['data'=>TariffResource::collection($tariffs), 'pagination'=>[]], 200);
    }

    public function add()
    {

    }

    public function edit($id)
    {

    }

    public function update()
    {

    }

    public function delete($id)
    {

    }
}
