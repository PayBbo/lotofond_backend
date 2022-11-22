<?php

namespace App\Http\Requests\Admin;

use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddUserRequest extends FormRequest
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
            'name'=>['required', 'string'],
            'surname'=>['required', 'string'],
            'middleName'=>['sometimes', 'nullable', 'string'],
            'email'=>['sometimes', 'nullable', 'required_without:phone', 'email', 'unique:users,email'],
            'phone'=>['sometimes', 'nullable', 'required_without:email', new Phone, 'unique:users,phone'],
            'password'=>['required', 'string', 'min:8'],
            'notificationsFromFavourite'=>['required', 'boolean'],
            'notificationsFromMonitoring'=>['required', 'boolean'],
            'notificationsToEmail'=>['required', 'boolean'],
            'roles'=>['nullable', 'array'],
            'roles.*'=>['string', 'exists:roles,name'],
            'tariff'=>['nullable', 'integer', 'exists:tariffs,id']
        ];
    }
}
