<?php

namespace App\Providers;

use App\Models\Auction;
use App\Models\ContentRule;
use App\Models\Lot;
use App\Models\LotFile;
use App\Models\Notification;
use App\Models\User;
use App\Observers\AuctionObserver;
use App\Observers\ContentRuleObserver;
use App\Observers\LotFileObserver;
use App\Observers\LotObserver;
use App\Observers\NotificationObserver;
use App\Observers\UserObserver;
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
        LotFile::observe(LotFileObserver::class);
        User::observe(UserObserver::class);
    }
}
