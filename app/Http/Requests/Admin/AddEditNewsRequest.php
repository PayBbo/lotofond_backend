<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddEditNewsRequest extends FormRequest
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
            'id' => ['sometimes', 'required', 'integer', 'exists:news,id'],
            'description' => ['sometimes', 'string', 'nullable', 'required_without_all:image,imageBinary'],
            'image' => ['sometimes', 'string', 'nullable', 'required_without_all:description,image'],
            'imageBinary' => ['sometimes', 'nullable', 'image', 'required_without_all:description,imageBinary'],
            'isBanner' => ['sometimes']
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if (isset($this->description)) {
            $this->merge([
                'description' => strlen((string)$this->description) > 0 ? $this->description : null
            ]);
        }
    }
}
