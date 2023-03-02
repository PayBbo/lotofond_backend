<?php

namespace App\Observers;

use App\Http\Services\CacheService;
use App\Jobs\SendApplication;
use App\Models\Lot;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class LotObserver
{
    /**
     * Handle the Lot "created" event.
     *
     * @param \App\Models\Lot $lot
     * @return void
     */
    public function created(Lot $lot)
    {
        $email = $lot->auction->arbitrationManager->email;
        if (!is_null($email)) {
            logger('Sent emails to organizers');
            logger($lot->id);
            logger($email);
            $debtor = $lot->auction->debtor;
            $debtorName = $debtor->name;
            if (!is_null($debtor->last_name)) {
                $debtorName = $debtor->last_name . ' ' . $debtor->name;
            }
            if (!is_null($debtor->last_name)) {
                $debtorName .= ' ' . $debtor->middle_name;
            }

            $subject = "Запрос информации по торгу должника: " . $debtorName;
            $tradeId = $lot->auction->trade_id;
            $idEfrsb = '. </p> <p> Ссылка на торги на федресурсе: https://fedresurs.ru/bidding/' . $lot->auction->guid . '</p>';
            if (!is_null($lot->auction->id_efrsb)) {
                $idEfrsb = ". </p> <p>Номер сообщения в ЕФРСБ: " . $lot->auction->id_efrsb . '</p>';
            }
            $html = "Добрый день, просим предоставить все имеющиеся документы и информацию по торгам № " . $tradeId . ", лоту №" . $lot->number .
                ".<p>Должник: " . $debtorName . ",  ИНН: " . $debtor->inn . $idEfrsb .
                "<br>
<p> С уважением,</p>
<p>ООО «Русвопрос»</p>";
            logger($html);
            /*$emails = Cache::get('contactEmails') ?? [];
            $counts = array_count_values($emails);
            $count = array_key_exists($email, $counts) ? $counts[$email] : 0;
            $delay = random_int(60, 360) * $count;
            logger('count ' . $count);
            logger($delay . ' sec');
            dispatch((new SendApplication($html, $subject, $email))->onQueue('credentials')->delay($delay));
            $emails[] = $email;
            Cache::put('contactEmails', $emails, Carbon::now()->setTimezone('Europe/Moscow')->addDay());*/
            logger('-----------------------');
        }

    }

    /**
     * Handle the Lot "updated" event.
     *
     * @param \App\Models\Lot $lot
     * @return void
     */
    public function updated(Lot $lot)
    {
        //
    }

    /**
     * Handle the Lot "deleted" event.
     *
     * @param \App\Models\Lot $lot
     * @return void
     */
    public function deleted(Lot $lot)
    {
        $cacheService = new CacheService();
        $cacheService->cacheCategoriesStatistics();
        $cacheService->cacheLotsStatistics();
        $cacheService->cachePricesForFilter();
    }

    /**
     * Handle the Lot "restored" event.
     *
     * @param \App\Models\Lot $lot
     * @return void
     */
    public function restored(Lot $lot)
    {
        //
    }

    /**
     * Handle the Lot "force deleted" event.
     *
     * @param \App\Models\Lot $lot
     * @return void
     */
    public function forceDeleted(Lot $lot)
    {
        //
    }
}
