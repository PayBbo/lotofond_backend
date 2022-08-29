<?php

namespace App\Http\Requests;

use App\Rules\CheckIsString;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNotificationsRequest extends FormRequest
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
            'notificationsFromFavourite'=>['required', 'boolean'],
            'notificationsFromMonitoring'=>['required', 'boolean'],
            'notificationsToEmail'=>['sometimes', 'boolean'],
            'notificationsSettings'=>['required', 'array'],
            'notificationsSettings.*'=>['required', 'integer', 'in:1,2,4,7', new CheckIsString]
        ];
    }
}
