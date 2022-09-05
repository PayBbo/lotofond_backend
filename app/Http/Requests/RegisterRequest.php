<?php

namespace App\Http\Requests;

use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => ['sometimes', 'required', 'email', 'unique:users'],
            'phone' => ['sometimes', 'required', new Phone, 'unique:users'],
            'surname'=>['sometimes','required', 'string', 'max:255'],
            'name'=>['sometimes','required', 'string', 'max:255'],
            'password'=>['sometimes','required', 'string', 'min:8'],
        ];
    }
}
