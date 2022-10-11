<?php

namespace App\Http\Requests;

use App\Models\ChangeCredentials;
use App\Rules\IsUniqueNewCredentials;
use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;

class GetCredentialsCodeRequest extends FormRequest
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
            'grantType' => ['required', 'string'],
            'email' => ['sometimes', 'required', 'email', 'unique:change_credentials,email',
                new IsUniqueNewCredentials($this->request->get('isOldCredentials'), $this->request->get('haveAccessToOldCredentials'))],
            'phone' => ['sometimes', 'required', new Phone, 'unique:change_credentials,phone',
                new IsUniqueNewCredentials($this->request->get('isOldCredentials'), $this->request->get('haveAccessToOldCredentials'))],
            'token'=>['sometimes', 'required', 'string'],
            'haveAccessToOldCredentials'=>['sometimes','required', 'boolean'],
            'isOldCredentials'=>['sometimes','required', 'boolean']
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        ChangeCredentials::where(['user_id'=>auth()->id(), 'email'=>$this->email, 'is_old_credentials'=>$this->isOldCredentials, 'is_submitted_new_credentials'=>false])->delete();
        ChangeCredentials::where(['user_id'=>auth()->id(), 'phone'=>$this->phone, 'is_old_credentials'=>$this->isOldCredentials, 'is_submitted_new_credentials'=>false])->delete();
    }
}
