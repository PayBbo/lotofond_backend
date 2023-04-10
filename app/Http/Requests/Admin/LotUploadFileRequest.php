<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LotUploadFileRequest extends FormRequest
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
            'lotId'=>['required', 'integer', 'exists:lots,id'],
            'files'=>['sometimes', 'array'],
            'files.*'=>['sometimes', 'nullable', 'file'],
            'images'=>['sometimes', 'array'],
            'images.*'=>['sometimes', 'nullable', 'image']

        ];
    }
}
