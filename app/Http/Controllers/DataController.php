<?php

namespace App\Http\Controllers;

use App\Http\Resources\TextDataResource;
use App\Models\TextData;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function getTextData(){
        $items = TextData::all();
        return response(TextDataResource::collection($items), 200);
    }
}
