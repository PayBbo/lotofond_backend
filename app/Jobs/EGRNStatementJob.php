<?php

namespace App\Jobs;

use App\Http\Services\ReestrApiService;
use App\Http\Services\SendCodeService;
use App\Models\EgrnStatement;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class EGRNStatementJob implements ShouldQueue
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
        $statements = EgrnStatement::where('file', null)->get();
        $orders = implode('; ',  $statements->pluck('order_id')->toArray());
        $reestr = new ReestrApiService();
        $results = $reestr->checkEgrnOrder($orders);
        if($results['query'] == 'success'){
            foreach($results['info'] as $result){
                $statement = $statements->where('order_id', $result['order_id'])->first();
                $statement->status = $result['status'];
                $statement->last_check_date = Carbon::now()->setTimezone('Europe/Moscow');
                if($result['status'] == 'Завершен') {
                    $contents = file_get_contents('https://reestr-api.ru/v1/order/download?auth_token='.config('reestr.auth_token').'&order_id='.$statement->order_id.'&format='.$statement->application->format);
                    Storage::disk('public')->put('statements/'.$statement->id.'/отчет-ЕГРН.'.$statement->application->format, $contents);
                    $statement->file = 'storage/statemens/'.$statement->id.'/отчет-ЕГРН.'.$statement->application->format;
                    $application = $statement->application;
                    $fileLink =  Storage::url('statements/'.$statement->id.'/отчет-ЕГРН.'.$statement->application->format);
                    $sendEmail = new SendCodeService();
                    $sendEmail->sendEGRNStatement($application, $fileLink);
                    $application->status = 'completed';
                    $application->save();

                }
                $statement->save();

            }
        }
    }
}
