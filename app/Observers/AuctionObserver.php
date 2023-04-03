<?php

namespace App\Observers;

use App\Jobs\SendApplication;
use App\Models\Auction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class AuctionObserver
{
    /**
     * Handle the Auction "created" event.
     *
     * @param  \App\Models\Auction  $auction
     * @return void
     */
    public function created(Auction $auction)
    {
        $email = $auction->arbitrationManager->email;
        if (!is_null($email)) {
            $debtor = $auction->debtor;
            $debtorName = $debtor->name;
            if (!is_null($debtor->last_name)) {
                $debtorName = $debtor->last_name . ' ' . $debtor->name;
            }
            if (!is_null($debtor->last_name)) {
                $debtorName .= ' ' . $debtor->middle_name;
            }

            $subject = "Запрос информации по торгу должника: " . $debtorName;
            $tradeId = $auction->trade_id;
            $idEfrsb = '. </p> <p> Ссылка на торги на федресурсе: https://fedresurs.ru/bidding/' . $auction->guid . '</p>';
            if (!is_null($auction->id_efrsb)) {
                $idEfrsb = ". </p> <p>Номер сообщения в ЕФРСБ: " . $auction->id_efrsb . '</p>';
            }
            $html = "Добрый день, просим предоставить все имеющиеся документы и информацию по торгам № " . $tradeId .
                ".<p>Должник: " . $debtorName . ",  ИНН: " . $debtor->inn . $idEfrsb .
                "<br>
<p>Лотофонд оставляет за собой право для публикации Вашего ответа на нашем ресурсе.</p>
<p> С уважением,</p>
<p>ООО «Русвопрос»</p>";

           /* $emails = Cache::get('contactEmails') ?? [];
            $counts = array_count_values($emails);
            $count = array_key_exists($email, $counts) ? $counts[$email] : 1;
            $delay = random_int(60, 360) * $count;
            dispatch((new SendApplication($html, $subject, $email, true))->onQueue('credentials')->delay($delay));
            $emails[] = $email;
            Cache::put('contactEmails', $emails, Carbon::now()->setTimezone('Europe/Moscow')->addDay());*/
            if(!Cache::has('emailsCount')){
                Cache::put('emailsCount', 1, Carbon::now()->setTimezone('Europe/Moscow')->startOfDay()->addDay());
            }else{
                Cache::increment('emailsCount');
            }
            if(!Cache::has('emailsHourCount')){
                Cache::put('emailsHourCount', 1, Carbon::now()->addHour());
            }else{
                Cache::increment('emailsHourCount');
            }
            $emailsCount = Cache::get('emailsCount');
            $emailsHourCount = Cache::get('emailsHourCount');
            if($emailsCount < 500) {
                $delay = 75 * $emailsHourCount;
                dispatch((new SendApplication($html, $subject, $email, true))->onQueue('credentials')->delay($delay));
            }
        }

    }

    /**
     * Handle the Auction "updated" event.
     *
     * @param  \App\Models\Auction  $auction
     * @return void
     */
    public function updated(Auction $auction)
    {
        //
    }

    /**
     * Handle the Auction "deleted" event.
     *
     * @param  \App\Models\Auction  $auction
     * @return void
     */
    public function deleted(Auction $auction)
    {
        //
    }

    /**
     * Handle the Auction "restored" event.
     *
     * @param  \App\Models\Auction  $auction
     * @return void
     */
    public function restored(Auction $auction)
    {
        //
    }

    /**
     * Handle the Auction "force deleted" event.
     *
     * @param  \App\Models\Auction  $auction
     * @return void
     */
    public function forceDeleted(Auction $auction)
    {
        //
    }
}
