<?php

namespace App\Http\Controllers;

use App\Http\Resources\TextDataResource;
use App\Models\TextData;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function getTextData($type){
        $items = TextData::where('type', $type)->get();
        return response(TextDataResource::collection($items), 200);
    }
}
