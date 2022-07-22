<?php

namespace App\Http\Requests;

use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
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
            'email'=>['required', 'email'],
            'phone'=>['required', new Phone],
            'lotId'=>['required', 'integer', 'exists:lots,id'],
            'socialsForAnswer'=>['required', 'array'],
            'socialsForAnswer.*'=>['required', 'string'],
        ];
    }
}
