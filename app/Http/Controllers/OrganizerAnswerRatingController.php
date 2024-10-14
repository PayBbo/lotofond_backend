<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrganizerAnswerRatingResource;
use App\Models\AdditionalLotInfo;
use App\Models\OrganizerAnswerRating;
use Illuminate\Http\Request;

class OrganizerAnswerRatingController extends Controller
{
    /**
     * Проверка прав на совершение действий
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:additions-list', ['only' => ['get']]);
        $this->middleware('permission:additions-edit', ['only' => ['update']]);
        $this->middleware('permission:additions-delete', ['only' => ['delete']]);
    }

    public function get(Request $request)
    {
        $ratings = OrganizerAnswerRating::when($request->get('user_id', null), function ($q) {
            $q->where('user_id', request()->get('user_id'));
        })->when($request->get('answer_id', null), function ($q) {
            $q->where('answer_id', request()->get('answer_id'));
        })->get();
        return response()->json(['ratings' => $ratings], 200);
    }

    public function create(Request $request)
    {
        try {
            $estimate = OrganizerAnswerRating::where(['user_id' => $request->get('user_id', auth()->id()), 'answer_id' => $request->answerId])->first();
            if (!$estimate || $request->admin) {
                $estimate = new OrganizerAnswerRating();
            }
            $estimate->estimate = $request->estimate;
            $estimate->comment = $request->comment;
            $estimate->user_id = $request->get('user_id', auth()->id());
            $estimate->answer_id = $request->answerId;
            $estimate->save();
            $answer = AdditionalLotInfo::find($request->answerId);
            $answer->rating = $answer->rating();
            if ($request->admin) {
                return response()->json(['rating' => $estimate, 'answer' => $answer], 200);
            }
            return response(new OrganizerAnswerRatingResource($answer), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        $estimate = OrganizerAnswerRating::find($request->id);
        if ($estimate) {
            //можно поменять только оценку и комментарий
            $estimate->estimate = $request->estimate;
            $estimate->comment = $request->comment;
//            $estimate->user_id = auth()->id();
//            $estimate->answer_id = $request->answerId;
            $estimate->save();
            return response()->json($estimate, 200);
        }
        return response()->json(['message' => 'Оценка не найдена'], 500);
    }

    public function delete(Request $request)
    {
        try {
            $estimate = OrganizerAnswerRating::find($request->id);
            if ($estimate) {
                $rating = 0;
                $answerId = $estimate->answer_id;
                $estimate->delete();
                if ($answerId) {
                    $answer = AdditionalLotInfo::find($answerId);
                    $rating = $answer ? $answer->rating() : 0;
                }
                return response()->json(['rating' => $rating, 'message' => 'Оценка успешно удалена'], 200);
            }
            return response()->json(['message' => 'Оценка не найдена'], 500);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }

}
