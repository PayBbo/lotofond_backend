<?php

namespace App\Http\Requests;

use App\Rules\IsUniqueFavouritePath;
use App\Rules\IsUserFavouritePath;
use Illuminate\Foundation\Http\FormRequest;

class FavouritePathRequest extends FormRequest
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
            'name'=>['required', 'string', 'max:255', new IsUniqueFavouritePath($this->request->get('pathId'))],
            'pathId'=>['sometimes', 'nullable', 'numeric', 'exists:favourites,id', new IsUserFavouritePath()],
            'color'=>['sometimes', 'string', 'nullable']
        ];
    }
}
