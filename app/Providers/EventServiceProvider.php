<?php

namespace App\Providers;

use App\Events\ConfirmOrder;
use App\Events\NewOrderUser;
use App\Events\NewUserRegistered;
use App\Listeners\ChangePassword;
use App\Listeners\ConfirmOrderClient;
use App\Listeners\SendRegisteredNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
            SendRegisteredNotification::class,
        ],
        ConfirmOrder::class => [
            ConfirmOrderClient::class,
        ],
        NewOrderUser::class => [
            ChangePassword::class,
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
