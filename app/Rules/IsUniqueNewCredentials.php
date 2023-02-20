<?php

namespace App\Rules;

use App\Models\ChangeCredentials;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class IsUniqueNewCredentials implements Rule
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
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = User::find(auth()->id());
        if ($this->isOldCredentials && $this->haveAccessToOldCredentials) {
            $exists = !User::where($attribute, $value)->exists();
            if($exists) {
                $this->message = 'not_enough_credentials';
                return !is_null($user[$attribute]);
            }else{
                return false;
            }
        } elseif ($this->haveAccessToOldCredentials && !$this->isOldCredentials) {
            if(!User::where($attribute, $value)->exists()) {
                if ($attribute == 'email') {
                    $this->message = 'credentials_submitted_email';
                } else {
                    $this->message = 'credentials_submitted_phone';
                }
            }
            $currentDate = Carbon::now()->setTimezone('Europe/Moscow');
            return !User::where($attribute, $value)->exists()
                && ChangeCredentials::where(['user_id' => $user->id, $attribute => $user[$attribute],
                    'is_submitted_old_credentials' => true, 'value'=>$value])
                    ->where('created_at', '>', $currentDate)
                    ->exists();
        } else {
            $this->message = 'exists';
            return !User::where($attribute, $value)->exists() &&
                !ChangeCredentials::where($attribute, $value)->exists();
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
