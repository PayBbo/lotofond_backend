<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Requests\NoteStoreRequest;
use App\Http\Requests\NoteUpdateRequest;
use App\Models\Note;
use Carbon\Carbon;

class NoteController extends Controller
{
    public function addNote(NoteStoreRequest $request){
        $note = Note::create([
           'user_id'=>auth()->id(),
           'title'=>$request->title,
           'item_id'=>$request->itemId,
           'item_type'=>$request->itemType,
           'date'=>Carbon::now()->setTimezone('Europe/Moscow')
        ]);
        return response(Note::where('id', $note->id)->select(['id', 'title', 'item_id AS itemId', 'item_type AS itemType', 'date'])->first(), 200);
    }

    public function editNote(NoteUpdateRequest $request){
        $note = Note::find($request->noteId);
        $note->title = $request->title;
        $note->date = Carbon::now()->setTimezone('Europe/Moscow');
        $note->save();
        return response(null, 200);
    }

    public function deleteNote(NoteUpdateRequest $request){
        Note::where('id', $request->noteId)->delete();
        return response(null, 200);
    }

    public function getNote($itemType, $itemId){
        $note = Note::where(['user_id'=>auth()->id(), 'item_type'=>$itemType, 'item_id'=>$itemId])
            ->select(['id', 'title', 'item_id AS itemId', 'item_type AS itemType', 'date'])->first();
        if(!$note){
            throw new BaseException("ERR_FIND_NOTE_FAILED", 404, "Note with itemId= " . $itemId . " and itemType= ". $itemType ." does not exist");
        }
        return response($note, 200);
    }

}
