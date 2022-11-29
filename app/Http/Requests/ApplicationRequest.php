<?php

namespace App\Http\Requests;

use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
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
            'email'=>['required', 'email'],
            'phone'=>['required', new Phone],
            'lotId'=>['sometimes', 'required', 'integer', 'exists:lots,id'],
            'name'=>['sometimes', 'required', 'string'],
            'socialsForAnswer'=>['required', 'array'],
            'socialsForAnswer.*'=>['required', 'string'],
            'paymentTradingTypes'=>['required', 'array'],
            'paymentTradingTypes.*' => ['required', 'string', 'in:purchaseBidByAgent,infoAboutLot,consultation,accompanimentFAS']
        ];
    }
}
