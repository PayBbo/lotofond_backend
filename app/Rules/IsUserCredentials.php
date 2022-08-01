<?php

namespace App\Rules;

use App\Models\ChangeCredentials;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class IsUserCredentials implements Rule
{
    protected $isOldCredentials;
    protected $haveAccessToOldCredentials;
    protected $message = 'exists';

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($isOldCredentials, $haveAccessToOldCredentials)
    {
        $this->isOldCredentials = $isOldCredentials;
        $this->haveAccessToOldCredentials = $haveAccessToOldCredentials;
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
        if ($this->isOldCredentials && $this->haveAccessToOldCredentials) {
           return ChangeCredentials::where(['user_id'=>auth()->id(), $attribute=>$value, 'is_old_credentials'=>true])->exists();
        } elseif ($this->haveAccessToOldCredentials && !$this->isOldCredentials) {
            if ($attribute == 'email') {
                $this->message = 'credentials_submitted_email';
            } else {
                $this->message = 'credentials_submitted_phone';
            }
            $currentDate = Carbon::now()->setTimezone('Europe/Moscow');
            return ChangeCredentials::where(['user_id' => auth()->id(), $attribute => $user[$attribute],
                    'is_submitted_old_credentials' => true])
                    ->where('created_at', '>', $currentDate)
                    ->exists() &&     ChangeCredentials::where(['user_id'=>auth()->id(), $attribute=>$value, 'is_old_credentials'=>false])->exists();;
        } else {
            return ChangeCredentials::where(['user_id'=>auth()->id(), $attribute=>$value])->exists();
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.' . $this->message);
    }
}
