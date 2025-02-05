<?php

namespace App\Http\Requests;

use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'email' => [
                'sometimes',
                'required',
                'email',
                Rule::unique('users','email')
                    ->where(function ($query){
                        return $query->where('email_verified_at', '!=', null);
                    }),
                'unique:change_credentials,email'
            ],
            'phone' => [
                'sometimes',
                'required',
                new Phone,
                Rule::unique('users','phone')
                    ->where(function ($query){
                        return $query->where('email_verified_at', '!=', null);
                    }),
                'unique:change_credentials,phone'
            ],
            'surname'=>['sometimes','required', 'string', 'max:255'],
            'name'=>['sometimes','required', 'string', 'max:255'],
            'password'=>['sometimes','required', 'string', 'min:8'],
            'region'=>['sometimes', 'required', 'string', 'exists:regions,code']
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
