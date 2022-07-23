<?php

namespace App\Http\Requests;

use App\Rules\IsUserEvent;
use Illuminate\Foundation\Http\FormRequest;

class EventUpdateRequest extends FormRequest
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
            'id'=>['required', 'integer', 'exists:events,id', new IsUserEvent()],
            'date' => ['required', 'date'],
            'time' => ['required'],
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:task,event,reminder']
        ];
    }
}
