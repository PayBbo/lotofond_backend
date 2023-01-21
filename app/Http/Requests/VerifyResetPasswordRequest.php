<?php

namespace App\Http\Requests;

use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;

class VerifyResetPasswordRequest extends FormRequest
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
            'password' => ['sometimes', 'required', 'string'],
            'code' => ['required', 'string', 'max:6', 'min:4']
        ];
    }
}
