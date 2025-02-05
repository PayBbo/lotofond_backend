<?php

namespace App\Http\Resources;

use App\Http\Services\CacheService;
use App\Models\ContentRule;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $changeCredentials = $this->changeCredentials()
            ->where(['is_old_credentials' => false, 'is_submitted_old_credentials' => false, 'is_submitted_new_credentials' => true])
            ->latest()->first();
        if(!Cache::has('trialPeriod')){
            $cacheService = new CacheService();
            $cacheService->cacheTrialPeriod();
        }
        $testPeriodInDays =  Cache::get('trialPeriod');
        $hasTariff = !is_null($this->tariff);
        $hasTestPeriod =$this->email_verified_at->addDays($testPeriodInDays)->format('Y-m-d H:i') >= Carbon::now()->setTimezone('Europe/Moscow')->format('Y-m-d H:i');


        if(!Cache::has('botTrialPeriod')){
            $cacheService = new CacheService();
            $cacheService->cacheBotTrialPeriod();
        }
        $botTestPeriodInDays =  Cache::get('botTrialPeriod');
        $hasBotTariff = !is_null($this->botTariff);
        $hasBotTestPeriod = $this->tg_connected_at->addDays($botTestPeriodInDays)->format('Y-m-d H:i') >= Carbon::now()->setTimezone('Europe/Moscow')->format('Y-m-d H:i');

        $contentDisplayRules = ['lot'=>['trade'=>[]], 'system'=>[]];
        $rules = ContentRule::all();
        foreach($rules as $rule){
            if($rule->type == 'trade'){
                $contentDisplayRules['lot'][$rule->type][$rule->code] = ($hasTariff || $hasTestPeriod) ? true : $rule->is_available;
            }else{
                $contentDisplayRules[$rule->type][$rule->code] = ($hasTariff || $hasTestPeriod) ? true : $rule->is_available;
            }

        }
        return [
            'email' => $this->email,
            'phone' => strlen($this->phone) > 0 ? $this->phone : null,
            'name' => $this->name,
            'middleName' => $this->middle_name,
            'lastName' => $this->surname,
            'notificationsFromFavourite' => $this->not_from_favourite,
            'notificationsFromMonitoring' => $this->not_from_monitoring,
            'notificationsToEmail' => $this->not_to_email,
            'notificationsSettings' => $this->not_settings,
            $this->mergeWhen(!is_null($changeCredentials), [
                'changeCredentialsProcess' => [
                    'changeCredentialsProcessId'=> !is_null($changeCredentials) ? $changeCredentials->id : null,
                    'newValueType' => !is_null($changeCredentials) ? (is_null($changeCredentials->email) ? 'phone' : 'email') : null,
                    'newValue' => !is_null($changeCredentials) ? (is_null($changeCredentials->email) ? $changeCredentials->phone : $changeCredentials->email) : null,
                    'dateOfChange' => !is_null($changeCredentials) ? (Carbon::parse($changeCredentials->created_at)->addDays(13)) : null
                ]
            ]),
            $this->mergeWhen(is_null($changeCredentials), [
                'changeCredentialsProcess' => null
            ]),
            $this->mergeWhen(!$hasTariff && $hasTestPeriod, [
                'tariff' => [
                    'title'=>__('payments.test_period'),
                    'expiredAt'=>$this->email_verified_at->addDays($testPeriodInDays)->format('d.m.Y H:i:s')
                ]
            ]),
            $this->mergeWhen($hasTariff && !$hasTestPeriod, [
                'tariff' => [
                    'title'=> !is_null($this->tariff) ? $this->tariff['tariff']->title : null,
                    'expiredAt'=>!is_null($this->tariff) ? Carbon::parse($this->tariff->finished_at)->format('d.m.Y H:i:s') : null
                ]
            ]),
            $this->mergeWhen(!$hasTariff && !$hasTestPeriod, [
                'tariff' => null
            ]),
            $this->mergeWhen(!$hasBotTariff && $hasBotTestPeriod, [
                'botTariff' => [
                    'title'=>__('payments.test_period'),
                    'expiredAt'=>$this->tg_connected_at->addDays($testPeriodInDays)->format('d.m.Y H:i:s'),
                    'trial' => true
                ]
            ]),
            $this->mergeWhen($hasBotTariff && !$hasBotTestPeriod, [
                'botTariff' => [
                    'title'=> !is_null($this->botTariff) ? $this->botTariff['tariff']->title : null,
                    'expiredAt'=>!is_null($this->botTariff) ? Carbon::parse($this->botTariff->finished_at)->format('d.m.Y H:i:s') : null,
                    'trial' => false
                ]
            ]),
            $this->mergeWhen(!$hasBotTariff && !$hasBotTestPeriod, [
                'botTariff' => null
            ]),
            'contentDisplayRules'=>$contentDisplayRules,
            'permissions' => $this->getAllPermissions()->pluck('name')->toArray(),
            'isAdmin'=>$this->hasRole('admin')
        ];
    }
}
