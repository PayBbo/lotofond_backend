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
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = User::find(auth()->id());
        if($this->isOldCredentials && $this->haveAccessToOldCredentials){
            return User::where([$attribute=>$value, 'id'=>$user->id])->exists();
        }elseif($this->haveAccessToOldCredentials && !$this->isOldCredentials){
            $this->message = 'credentials_submitted';
            $currentDate = Carbon::now()->setTimezone('Europe/Moscow');
            return !User::where($attribute, $value)->exists()
                && ChangeCredentials::where(['user_id'=>$user->id, 'email'=>$user->email,
                    'is_submitted_old_credentials'=>true])
                    ->where('created_at', '>', $currentDate)
                    ->exists();
        }else{
            return !User::where($attribute, $value)->exists();
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
