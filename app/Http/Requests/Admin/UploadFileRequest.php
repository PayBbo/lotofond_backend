<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UploadFileRequest extends FormRequest
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
            'id'=>['required', 'numeric'],
            'type'=>['required', 'string', 'in:additions,lot'],
            'image'=>['sometimes', 'image'],
            'file'=>['sometimes']
        ];
    }
}
