<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

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
        return [
            'email' => $this->email,
            'phone' => $this->phone,
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
            $this->mergeWhen(is_null($this->tariff) &&
                $this->email_verified_at->addDays(3)->format('d.m.Y H:i:s') >= Carbon::now()->setTimezone('Europe/Moscow')->format('d.m.Y H:i:s'), [
                'tariff' => [
                    'title'=>'Тестовый период',
                    'expiredAt'=>$this->email_verified_at->addDays(3)->format('d.m.Y H:i:s')
                ]
            ]),
            $this->mergeWhen(!is_null($this->tariff) &&
                $this->email_verified_at->addDays(3)->format('d.m.Y H:i:s') < Carbon::now()->setTimezone('Europe/Moscow')->format('d.m.Y H:i:s'), [
                'tariff' => [
                    'title'=> !is_null($this->tariff) ? $this->tariff['tariff']->title : null,
                    'expiredAt'=>!is_null($this->tariff) ? Carbon::parse($this->tariff->finished_at)->format('d.m.Y H:i:s') : null
                ]
            ]),
            $this->mergeWhen(is_null($this->tariff) &&
                $this->email_verified_at->addDays(3)->format('d.m.Y H:i:s') < Carbon::now()->setTimezone('Europe/Moscow')->format('d.m.Y H:i:s'), [
                'tariff' => null
            ])
        ];
    }
}
