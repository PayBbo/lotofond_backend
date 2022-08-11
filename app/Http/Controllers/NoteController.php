<?php

namespace App\Http\Controllers;

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
        return response($note, 200);
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

}
