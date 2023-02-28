<?php

namespace App\Observers;

use App\Models\ContentRule;
use Illuminate\Support\Facades\Cache;

class ContentRuleObserver
{
    /**
     * Handle the ContentRule "created" event.
     *
     * @param  \App\Models\ContentRule  $contentRule
     * @return void
     */
    public function created(ContentRule $contentRule)
    {
        $this->cacheRules();
    }

    /**
     * Handle the ContentRule "updated" event.
     *
     * @param  \App\Models\ContentRule  $contentRule
     * @return void
     */
    public function updated(ContentRule $contentRule)
    {
        $this->cacheRules();
    }

    /**
     * Handle the ContentRule "deleted" event.
     *
     * @param  \App\Models\ContentRule  $contentRule
     * @return void
     */
    public function deleted(ContentRule $contentRule)
    {
        $this->cacheRules();
    }

    /**
     * Handle the ContentRule "restored" event.
     *
     * @param  \App\Models\ContentRule  $contentRule
     * @return void
     */
    public function restored(ContentRule $contentRule)
    {
        //
    }

    /**
     * Handle the ContentRule "force deleted" event.
     *
     * @param  \App\Models\ContentRule  $contentRule
     * @return void
     */
    public function forceDeleted(ContentRule $contentRule)
    {
        //
    }

    private function cacheRules(){

        Cache::forget('contentRules');
        Cache::forever('contentRules', ContentRule::all()->pluck('is_available', 'code'));

    }
}
