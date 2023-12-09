<?php

namespace App\Providers;

use App\Events\PiiBreached;
use App\Events\SendPiiBreachedAlert;
use App\Listeners\CreatePiiDashboardAlert;
use App\Listeners\SendPiiAlertOnSlack;
use App\Listeners\SendPiiAlertOnTelegram;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        PiiBreached::class => [
            CreatePiiDashboardAlert::class,
            SendPiiAlertOnTelegram::class,
            SendPiiAlertOnSlack::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
