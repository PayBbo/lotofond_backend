<?php

namespace App\Rules;

use App\Models\Note;
use Illuminate\Contracts\Validation\Rule;

class IsOneNoteForItem implements Rule
{
    protected $id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($itemId)
    {
        $this->id = $itemId;
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
        return !Note::where(['user_id'=>auth()->id(), 'item_id'=>$this->id, 'item_type'=>$value])->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.one_note');
    }
}
