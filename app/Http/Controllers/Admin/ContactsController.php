<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContactRequest;
use App\Models\Contact;
use App\Models\Tariff;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    /**
     * Проверка прав на совершение действий
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:emails-list', ['only' => ['get']]);
        $this->middleware('permission:emails-add', ['only' => ['update']]);
        $this->middleware('permission:emails-delete', ['only' => ['delete']]);
    }

    public function update(ContactRequest $request)
    {
        $contact = new Contact();
        $contact->contact = $request->contact;
        $contact->tariff_id = $request->type;
        $contact->save();
        return response(null, 200);
    }

    public function get(Request $request)
    {
        $type = $request->query('param');
        $sortParam = $request->query('sort_property');
        $sortDirection = $request->query('sort_direction');
        $contacts = Contact::when(isset($type), function ($query) use ($type) {
            $query->where('tariff_id', $type);
        })
            ->join('tariffs as tariff', 'tariff.id', '=', 'contacts.tariff_id')
            ->select('contacts.id', 'tariff.title->ru as type', 'contact')
            ->when(isset($sortParam) && isset($sortDirection), function ($query) use ($sortParam, $sortDirection) {
                $query->orderBy($sortParam, $sortDirection);
            })
            ->get();
        $types = Tariff::whereIn('type', ['service', 'system'])->select('id', 'title->ru as value')->get();
        return response(['data' => $contacts, 'pagination' => [], 'types' => $types], 200);
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
