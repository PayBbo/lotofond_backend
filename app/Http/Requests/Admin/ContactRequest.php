<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'contact'=>['required', 'string', 'email'],
            'type'=>['required', 'string', 'in:Отправка заявок на покупку без ЕП,Отправка заявок на покупки через агента,Отправка форм с вопросами,Отправка контактных форм']
        ];
    }

    public function messages()
    {
        return [
            'contact.*' => 'Поле Почта заполнено неверно',
            'type.*' => 'Поле Назначение почты заполнено неверно'
        ];
    }
}
