<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TextDataRequest extends FormRequest
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
            'header' => ['required', 'string', 'max:255'],
            'value' => ['required', 'string'],
            'type' => ['sometimes', 'required', 'in:info,help,about,contacts'],
            'screen' => ['sometimes', 'required', 'in:О приложении,Помощь,О нас,Контакты']
        ];
    }

    public function messages()
    {
        return [
            'header.*' => 'Поле Заголовок раздела заполнено неверно',
            'value.*' => 'Поле значение заполнено неверно',
            'screen.*' => 'Поле экран заполнено неверно'
        ];
    }
}
