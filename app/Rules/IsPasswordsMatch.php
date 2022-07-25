<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class IsPasswordsMatch implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    protected $password;
    protected $isSubmit;
    protected $message = 'new_user_password';

    public function __construct($password, $isSubmit)
    {
        $this->isSubmit = $isSubmit;
        if($isSubmit){
            $this->message = 'submit_user_password';
            $this->password = Hash::make($password);
        }else{
            $user = User::find(auth()->id());
            $this->password = $user->password;
        }
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
        if($this->isSubmit) {
            return Hash::check($value, $this->password);
        }else{
            return !Hash::check($value, $this->password);
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.'.$this->message);
    }
}
