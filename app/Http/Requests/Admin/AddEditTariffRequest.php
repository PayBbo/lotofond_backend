<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddEditTariffRequest extends FormRequest
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
            'title'=>['required', 'array'],
            'description'=>['required', 'array'],
            'title.*'=>['required', 'string'],
            'description.*'=>['required', 'string'],
            'price'=>['required', 'numeric'],
            'period'=>['required', 'numeric'],
            'includedDetails'=>['nullable', 'array'],
            'includedDetails.*'=>['nullable', 'array'],
            'includedDetails.*.*'=>['required', 'string'],
            'excludedDetails'=>['nullable', 'array'],
            'excludedDetails.*'=>['nullable', 'array'],
            'excludedDetails.*.*'=>['required', 'string']

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
