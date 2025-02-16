<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Import Model User


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        View::composer('*', function ($view) {
            if (Auth::check()) {
                // Eager load relasi notifications
                $user = Auth::user();
                $count = Auth::user()->unreadNotifications()->count();
                $view->with('unreadNotificationCount', $count);

            } else {
                $view->with('unreadNotificationCount', 0);
            }
        });
    }
}