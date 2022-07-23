<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Lot;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function getStatisticsByCategories(){
        $categories = Category::where('parent_id', null)->get();
        $data = [];
        $active_statuses = [1, 2];
        foreach($categories as $category){
            $ids = $category->subcategories()->pluck('title');
            $ids[] = $category->title;
            $data[$category->title] = [
                'allLotsCount'=> Lot::whereHas('categories', function ($q) use ($ids) {
                    $q->whereIn('categories.title', $ids);
                })->count(),
                'activeLotsCount'=>Lot::whereIn('status_id', $active_statuses)
                    ->whereHas('categories', function ($q) use ($ids) {
                    $q->whereIn('categories.title', $ids);
                })->count()
            ];
        }
        return response($data, 200);
    }

    public function getStatisticsByLots(){
        $active_statuses = [1, 2];
        $date = Carbon::now()->setTimezone('Europe/Moscow');
        $data = [
            'activeLotsCount'=>Lot::whereIn('status_id', $active_statuses)->count(),
            'nonactiveLotsCount'=>Lot::whereNotIn('status_id', $active_statuses)->count(),
            'allLotsCount'=>Lot::count(),
            'newLotsCount'=>Lot::whereDate('created_at',$date)->count()
        ];
        return response($data, 200);

    }
}
