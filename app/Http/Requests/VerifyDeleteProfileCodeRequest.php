<?php

namespace App\Http\Requests;

use App\Rules\DeleteProfileVerifyCode;
use Illuminate\Foundation\Http\FormRequest;

class VerifyDeleteProfileCodeRequest extends FormRequest
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
            'grantType'=>['required', 'string'],
            'code'=>['required', 'string', 'max:6', 'min:4', new DeleteProfileVerifyCode($this->request->get('grantType'))]
        ];
    }
}
