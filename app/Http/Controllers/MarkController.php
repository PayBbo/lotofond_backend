<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomExceptions\BaseException;
use App\Models\Lot;
use App\Models\Mark;
use Illuminate\Http\Request;

class MarkController extends Controller
{
    public function addMark(Request $request){
        $request->validate([
            'lotId'=>['required', 'integer', 'exists:lots,id'],
            'mark'=>['required', 'string']
        ]);
        $mark = Mark::where(['user_id'=>auth()->id(), 'title'=>$request->mark])->first();
        if(!$mark){
            $mark = Mark::create([
                'user_id'=>auth()->id(),
                'title'=>$request->mark
            ]);
        }
        $lot = Lot::find($request->lotId);
        if(!$lot->marks->contains($mark)){
            $lot->marks()->attach($mark);
        }
        return response(null, 200);
    }

    public function deleteMark($markId, $lotId){
        $mark = Mark::find($markId);
        $lot = Lot::find($lotId);
        if (!$mark || !$lot || $mark->user_id != auth()->id()) {
            throw new BaseException("ERR_ACCESS_FORBIDDEN", 403, "The user does not have rights to edit the selected mark");
        }
        if ($lot->userMarks->contains($mark)) {
            $lot->userMarks()->detach($mark);
        }

        return response(null, 200);
    }

    public function getMarksByLot($lotId){
        $lot = Lot::find($lotId);
        if (!$lot) {
            throw new BaseException("ERR_FIND_LOT_FAILED", 404, "Lot with id= " . $lotId . ' does not exist');
        }
        $marks = $lot->userMarks()->select('id', 'title')->get();
        return response($marks->makeHidden(['pivot']), 200);
    }

    public function getMarks(){
        $marks = Mark::where('user_id', auth()->id())->select('id', 'title')->get();
        return response($marks, 200);
    }
}
