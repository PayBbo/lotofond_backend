<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\TariffResource;
use App\Models\Tariff;
use Illuminate\Http\Request;

class TariffController extends Controller
{
    public function get()
    {
        $tariffs = Tariff::all();
        return response(['data'=>TariffResource::collection($tariffs), 'pagination'=>[]], 200);
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
