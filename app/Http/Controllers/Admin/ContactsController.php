<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function update(ContactRequest $request){
        $contact = Contact::create([
            'contact'=>$request->contact,
            'type'=>$request->type
        ]);
        return response(null, 200);
    }

    public function get(Request $request){
        $type = $request->query('param');
        $contacts = Contact::when(isset($type), function($query) use ($type) {
            $query->where('type', $type);
        })->get();
        $types = ['Отправка заявок на покупку без ЕП', 'Отправка заявок на покупки через агента', 'Отправка форм с вопросами', 'Отправка контактных форм'];
        return response(['data'=>$contacts,'pagination'=>[], 'types'=>$types], 200);
    }

    public function delete($id)
    {
        $contact = Contact::find($id);
        if ($contact) {
            $contact->delete();
            return response(null, 200);
        }
        return response(null, 404);
    }
}
