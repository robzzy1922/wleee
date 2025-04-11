<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\OrderStatusUpdated;
use App\Listeners\SendOrderNotification;
use App\Listeners\NotifyCustomerOrderStatus;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        OrderStatusUpdated::class => [
            SendOrderNotification::class,
            NotifyCustomerOrderStatus::class, // ✅ Tambahkan dengan benar
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot()
    {
        parent::boot();
    }
}
