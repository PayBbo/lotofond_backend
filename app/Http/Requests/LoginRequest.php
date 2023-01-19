<?php

namespace App\Http\Requests;

use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => ['sometimes', 'required', 'email', 'exists:users'],
            'phone' => ['sometimes', 'required', new Phone, 'exists:users'],
            'password' => ['sometimes', 'required', 'string']
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if(isset($this->phone)) {
            $this->merge([
                'phone' => preg_replace('/\D/', '', $this->phone)
            ]);
        }
    }
}
