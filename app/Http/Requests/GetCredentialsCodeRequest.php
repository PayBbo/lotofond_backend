<?php

namespace App\Http\Requests;

use App\Rules\IsUniqueNewCredentials;
use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;

class GetCredentialsCodeRequest extends FormRequest
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
            'email' => ['sometimes', 'required', 'email',
                new IsUniqueNewCredentials($this->request->get('isOldCredentials'), $this->request->get('haveAccessToOldCredentials'))],
            'phone' => ['sometimes', 'required', new Phone,
                new IsUniqueNewCredentials($this->request->get('isOldCredentials'), $this->request->get('haveAccessToOldCredentials'))],
            'haveAccessToOldCredentials'=>['required', 'boolean'],
            'isOldCredentials'=>['required', 'boolean']
        ];
    }
}
