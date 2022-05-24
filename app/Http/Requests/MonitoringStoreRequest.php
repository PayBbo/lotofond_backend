<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MonitoringStoreRequest extends FormRequest
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
            'user_id' => ['required', 'integer', 'gt:0'],
            'title' => ['required', 'string', 'max:255'],
            'not_frequency' => ['required', 'integer'],
            'unnecessary_words' => ['json'],
            'right_words' => ['json'],
        ];
    }
}
