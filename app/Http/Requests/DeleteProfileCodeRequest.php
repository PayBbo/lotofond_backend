<?php

namespace App\Http\Requests;

use App\Rules\DeleteProfileGrantType;
use App\Rules\ValidateSocialToken;
use Illuminate\Foundation\Http\FormRequest;

class DeleteProfileCodeRequest extends FormRequest
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
            'grantType'=>['required','string', new DeleteProfileGrantType($this->request->get('token'))],
            'token'=>['sometimes', 'string']
        ];
    }
}
