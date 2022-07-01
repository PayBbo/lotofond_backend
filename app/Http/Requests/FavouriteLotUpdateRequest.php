<?php

namespace App\Http\Requests;

use App\Rules\IsUserFavouritePath;
use Illuminate\Foundation\Http\FormRequest;

class FavouriteLotUpdateRequest extends FormRequest
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
            'currentPathId' => ['required', 'integer', new IsUserFavouritePath()],
            'newPathId' => ['required', 'integer', new IsUserFavouritePath()],
            'lotId'=>['required', 'integer', 'exists:lots,id']
        ];
    }
}
