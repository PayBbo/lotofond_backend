<?php

namespace App\Http\Services;

use App\Models\Lot;

class SortService
{

    public function getSortField($request, $lots)
    {
        if (isset($request->sort) && isset($request->sort['direction']) && strlen((string)$request->sort['direction']) > 0
            && isset($request->sort['type'])  && strlen((string)$request->sort['type']) > 0)
        {
            switch($request->sort['type']){
                case 'publishDate':{
                    $lots->orderByPublishDate($request->sort['direction']);
                    break;
                }
                case 'currentPrice':{
                    $lots->orderByCurrentPrice($request->sort['direction']);
                    break;
                }
                case 'eventStart':{
                    $lots->orderByEventStart($request->sort['direction']);
                    break;
                }
                case 'eventEnd':{
                    $lots->orderByEventEnd($request->sort['direction']);
                    break;
                }
                case 'applicationStart':{
                    $lots->orderByApplicationStart($request->sort['direction']);
                    break;
                }
                case 'applicationEnd':{
                    $lots->orderByApplicationEnd($request->sort['direction']);
                    break;
                }
            }
        }
        return $lots;
    }

}
