<?php

namespace App\Http\Requests;

use App\Rules\IsPasswordsMatch;
use App\Rules\IsUserPassword;
use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'email' => ['sometimes', 'required', 'email', 'exists:users', 'exists:password_resets,email'],
            'phone' => ['sometimes', 'required', new Phone, 'exists:users', 'exists:password_resets,email'],
            'oldPassword' => ['required', 'string',  new IsUserPassword],
            'newPassword' => ['required', 'string',  new IsPasswordsMatch(null, false)],
            'submitNewPassword' => [ 'required', 'string',  new IsPasswordsMatch($this->request->get('newPassword'), true)],
            'code' => ['required', 'string']
        ];
    }
}
