<?php

namespace App\Jobs;

use App\Http\Services\Parse\SoapWrapperService;
use App\Models\Bidder;
use App\Models\RegistryNotification;
use App\Models\RegistryNotificationType;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Midnite81\Xml2Array\Xml2Array;

class ParseDebtorMessages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $startFrom = Carbon::now()->setTimezone('Europe/Moscow')->subDays(9)->format('Y-m-d\TH:i:s');
        $endTo = Carbon::now()->setTimezone('Europe/Moscow')->format('Y-m-d\TH:i:s');
        $soapWrapper = new SoapWrapper();
        $service = new SoapWrapperService($soapWrapper);
        $messages = $service->getMessageIds($startFrom, $endTo);
        foreach ($messages->int as $message) {
            if (RegistryNotification::where('message_id', $message)->exists()) {
                continue;
            }
            $messageContent = $service->getMessageContent($message);
            $data = Xml2Array::create($messageContent)->toArray();
            try {
                if(!array_key_exists('BankruptId', $data)){
                    continue;
                }
                $messageType = $data['MessageInfo']['@attributes']['MessageType'];
                $debtor = Bidder::where('bankrupt_id', $data['BankruptId'])->first();
                $type = RegistryNotificationType::where('title', 'LIKE', '%' . $messageType . '%')->first();
                if ($debtor && $type) {
                    $files = null;
                    if (array_key_exists('MessageURLList', $data)) {
                        if (count($data['MessageURLList']['MessageURL']) > 1) {
                            foreach ($data['MessageURLList']['MessageURL'] as $url) {
                                $files[] = $url['@attributes']['URL'];
                            }

                        } else {
                            $files[] = $data['MessageURLList']['MessageURL']['@attributes']['URL'];
                        }
                    }
                    RegistryNotification::create([
                        'message_id' => $message,
                        'debtor_id' => $debtor->id,
                        'type_id' => $type->id,
                        'files' => $files,
                        'publish_date' => $data['PublishDate'],
                        'guid'=>$data['MessageGUID']
                    ]);
                }
            } catch (\Exception $e) {
                logger('ParseDebtorMessages');
                logger($e);
                logger($data);
            }
        }
    }

}
