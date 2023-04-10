<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'contact'=>['required', 'string', 'email',
                Rule::unique('contacts')->where(function ($query) {
                    return $query->where('tariff_id', $this->type);
                })
            ],
            'type'=>['required', 'numeric', 'exists:tariffs,id']
        ];
    }

    public function messages()
    {
        return [
            'contact.unique' => 'Выбранное значение почты уже существует для выбранного назначения рассылки',
            'contact.*' => 'Поле Почта заполнено неверно',
            'type.*' => 'Поле Назначение почты заполнено неверно'
        ];
    }
}
