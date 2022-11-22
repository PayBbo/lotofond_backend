<?php

namespace App\Http\Requests\Admin;

use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $this->request->set('phone', preg_replace('/\D/', '', $this->request->get('phone')));
        return [
            'id'=>['required', 'integer', 'exists:users,id'],
            'name'=>['required', 'string'],
            'surname'=>['required', 'string'],
            'middleName'=>['sometimes', 'nullable', 'string'],
            'email'=>['sometimes', 'nullable', 'required_without:phone', 'email', 'unique:users,email,'.$this->request->get('id')],
            'phone'=>['sometimes', 'nullable', 'required_without:email', new Phone, 'unique:users,phone,'.$this->request->get('id')],
            'roles'=>['nullable', 'array'],
            'roles.*'=>['string', 'exists:roles,name'],
            'tariff'=>['nullable', 'integer', 'exists:tariffs,id']
        ];
    }
}
