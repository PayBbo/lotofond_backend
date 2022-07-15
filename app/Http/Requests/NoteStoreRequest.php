<?php

namespace App\Http\Requests;

use App\Rules\IsExistsNoteItem;
use App\Rules\IsOneNoteForItem;
use Illuminate\Foundation\Http\FormRequest;

class NoteStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'itemId' => ['required', 'integer', 'gt:0', new IsExistsNoteItem($this->request->get('itemType'))],
            'itemType' => ['required', 'in:debtor,lot,organizer', new IsOneNoteForItem($this->request->get('itemId'))]
        ];
    }
}
