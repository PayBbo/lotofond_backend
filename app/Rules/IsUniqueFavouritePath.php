<?php

namespace App\Rules;

use App\Models\Favourite;
use Illuminate\Contracts\Validation\Rule;

class IsUniqueFavouritePath implements Rule
{
    protected $id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($pathId)
    {
        $this->id = $pathId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(isset($this->id)) {
            return !Favourite::where('id', '!=', $this->id)->where(['user_id' => auth()->id(), 'title' => $value])->exists();
        }else{
            return !Favourite::where(['user_id' => auth()->id(), 'title' => $value])->exists();
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.unique_path');
    }
}
