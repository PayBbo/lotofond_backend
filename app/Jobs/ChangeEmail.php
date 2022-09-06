<?php

namespace App\Jobs;

use App\Models\ChangeCredentials;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ChangeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $changeCredentialsId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->changeCredentialsId = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $changeCredentials = ChangeCredentials::find($this->changeCredentialsId);
        if($changeCredentials ){
            $user = User::find($changeCredentials->user_id);
            if(!is_null($changeCredentials->email) && !User::where('email', $changeCredentials->email)->exists()){
                $user->email = $changeCredentials->email;
            }
            if(!is_null($changeCredentials->phone) && !User::where('phone', $changeCredentials->phone)->exists()){
                $user->phone = $changeCredentials->phone;
            }
            $user->save();
            ChangeCredentials::where('user_id', $user->id)->delete();
        }
    }
}
