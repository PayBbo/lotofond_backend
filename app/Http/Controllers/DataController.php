<?php

namespace App\Http\Controllers;

use App\Http\Resources\NewsResource;
use App\Http\Resources\TextDataResource;
use App\Models\ContentRule;
use App\Models\News;
use App\Models\TextData;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function getTextData($type){
        $items = TextData::where('type', $type)->get();
        return response(TextDataResource::collection($items), 200);
    }

    public  function getContentRules(){
        $contentDisplayRules = ['lot'=>['trade'=>[]], 'system'=>[]];
        $rules = ContentRule::all();
        foreach($rules as $rule){
            if($rule->type == 'trade'){
                $contentDisplayRules['lot'][$rule->type][$rule->code] =  $rule->is_available;
            }elseif ($rule->code == 'hasAccessToFavourite'){
                $contentDisplayRules[$rule->type][$rule->code] = false;
            }
            else{
                $contentDisplayRules[$rule->type][$rule->code] = $rule->is_available;
            }

        }
        return response($contentDisplayRules, 200);
    }

    public function getInformationMessage(){
        $news = News::where('is_banner', true)->first();
        $shortNewsItem = null;
        if($news){
            $shortNewsItem = new NewsResource($news);
        }
        return response(['shortNewsItem'=>$shortNewsItem], 200);
    }
}
