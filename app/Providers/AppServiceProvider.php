<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notification;
use App\Services\Auth\AuthServiceProxy;
use App\Services\Auth\RealAuthService;
use App\Services\Auth\IAuthService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IAuthService::class, function ($app) {
            return new AuthServiceProxy(new RealAuthService());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    View::composer('*', function ($view) {
        $view->with('notifications', Notification::all());
    });
}
}