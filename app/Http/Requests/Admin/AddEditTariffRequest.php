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
            'title.*.*' => 'Один из переводов названия тарифа заполнен неверно',
            'description.*.*' => 'Один из переводов описания тарифа заполнен неверно',
            'title.*' => 'Поле Заголовок тарифа заполнено неверно',
            'description.*' => 'Поле Описание тарифа заполнено неверно',
            'price.*' => 'Поле цена заполнено неверно',
            'period.*' => 'Поле период действия тарифа заполнено неверно',
            'includedDetails.*.*.*' => 'Один из переводов включаемых возможностей заполнен неверно',
            'excludedDetails.*.*.*' => 'Один из переводов исключаемых возможностей заполнен неверно',
            'includedDetails.*' => 'Поле Включаемые возможности заполнено неверно',
            'excludedDetails.*' => 'Поле Исключаемые заполнено неверно',
        ];
    }
}
