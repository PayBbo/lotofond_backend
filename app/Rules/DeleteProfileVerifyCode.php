<?php

namespace App\Rules;

use App\Models\User;
use App\Models\VerifyAccount;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class DeleteProfileVerifyCode implements Rule
{
    protected $grantType;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($grantType)
    {
        $this->grantType = $grantType;
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
        $user = User::find(auth()->id());
        $currentDate = Carbon::now()->setTimezone('Europe/Moscow');
        $verifyAccount = null;
        switch ($this->grantType){
            case 'email':{
                if(!is_null($user->email))
                {
                    $verifyAccount = VerifyAccount::where('value', $user->email)->where('created_at', '>', $currentDate)->first();
                }
                break;
            }
            case 'phone':{
                if(!is_null($user->phone)) {
                    $verifyAccount = VerifyAccount::where('phone', $user->phone)->where('created_at', '>', $currentDate)->first();
                }
                break;
            }
        }
        return $verifyAccount && Hash::check($value, $verifyAccount->token);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.verification_code');
    }
}
