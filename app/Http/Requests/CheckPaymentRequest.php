<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckPaymentRequest extends FormRequest
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
        if(strpos($this->request->get('paymentId'), "?")) {
            $this->request->set('paymentId', substr($this->request->get('paymentId'), 0, strpos($this->request->get('paymentId'), "?")));
        }
        return [
            'paymentId'=>['required', 'string', 'exists:payments,token']
        ];
    }
}
