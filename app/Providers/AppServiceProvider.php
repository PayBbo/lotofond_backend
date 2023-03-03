<?php

namespace App\Providers;

use App\Models\Auction;
use App\Models\ContentRule;
use App\Models\Lot;
use App\Models\Notification;
use App\Observers\AuctionObserver;
use App\Observers\ContentRuleObserver;
use App\Observers\LotObserver;
use App\Observers\NotificationObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        ContentRule::observe(ContentRuleObserver::class);
        Lot::observe(LotObserver::class);
        Auction::observe(AuctionObserver::class);
        Notification::observe(NotificationObserver::class);
    }
}
