<?php

namespace App\Rules;

use App\Models\Bidder;
use App\Models\Lot;
use Illuminate\Contracts\Validation\Rule;

class IsExistsNoteItem implements Rule
{
    protected $type;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($itemType)
    {
        $this->type = $itemType;
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
        if($this->type == 'lot'){
            $isExists = Lot::where('id', $value)->exists();
        }else{
            $isExists = Bidder::where('id', $value)->whereHas('types', function ($query) {
                $query->where('title', $this->type);
            })->exits();
        }
        return $isExists;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.exists');
    }
}
