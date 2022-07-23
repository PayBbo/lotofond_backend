<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstimateBidderRequest extends FormRequest
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
            'estimate'=>['required', 'integer', 'min:1', 'max:5'],
            'comment'=>['nullable', 'string'],
            'bidderId'=>['required', 'integer', 'exists:bidders,id'],
            'type'=>['required', 'string', 'in:organizer,arbitrationManager']
        ];
    }
}
