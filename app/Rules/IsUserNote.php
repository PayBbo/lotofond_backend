<?php

namespace App\Rules;

use App\Models\Note;
use Illuminate\Contracts\Validation\Rule;

class IsUserNote implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        return Note::where(['id'=>$value, 'user_id'=>auth()->id()])->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.exists_note');
    }
}
