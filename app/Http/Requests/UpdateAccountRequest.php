<?php

namespace App\Http\Requests;

use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountRequest extends FormRequest
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
            'lastName'=>['required', 'string', 'max:255'],
            'name'=>['required', 'string', 'max:255'],
            'middleName'=>['string', 'nullable']
            //'email'=>['required', 'email', 'unique:users,email,'.auth()->user()->getAuthIdentifier()],
           // 'phone'=>['required', 'string', 'unique:users,phone,'.auth()->user()->getAuthIdentifier(), new Phone],
        ];
    }
}
