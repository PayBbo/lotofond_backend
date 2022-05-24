<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventStoreRequest extends FormRequest
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
            'date' => ['required', 'date'],
            'time' => ['required'],
            'title' => ['required', 'string', 'max:255'],
            'event_type_id' => ['required', 'integer', 'gt:0'],
            'user_id' => ['required', 'integer', 'gt:0'],
        ];
    }
}
