<?php

namespace App\Http\Requests;

use App\Rules\IsUserCredentials;
use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;

class VerifyCredentialsCodeRequest extends FormRequest
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
            'grantType' => ['required', 'string'],
            'email' => ['sometimes', 'required', 'email', 'exists:change_credentials,email',
                new IsUserCredentials($this->request->get('isOldCredentials'), $this->request->get('haveAccessToOldCredentials'))],
            'phone' => ['sometimes', 'required', new Phone, 'exists:change_credentials,phone',
                new IsUserCredentials($this->request->get('isOldCredentials'), $this->request->get('haveAccessToOldCredentials'))],
            'isOldCredentials'=>['required', 'boolean'],
            'haveAccessToOldCredentials'=>['required', 'boolean'],
            'code'=>['required', 'string', 'max:6', 'min:4']
        ];
    }
}
