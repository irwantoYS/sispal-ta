<?php

namespace App\Providers;

use App\Events\PerjalananCreated;
use App\Listeners\SendPerjalananCreatedNotification;
use App\Events\PerjalananStatusUpdated;
use App\Listeners\SendPerjalananStatusUpdatedNotification;
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
        PerjalananCreated::class => [
            SendPerjalananCreatedNotification::class,
        ],
        PerjalananStatusUpdated::class => [
            SendPerjalananStatusUpdatedNotification::class,
        ],
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
