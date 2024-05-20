<?php

namespace App\Providers;

// use Jenssegers\Date;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

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

        Gate::define('viewPulse', function (User $user) {
            return $user->id > 0;
        });

        RateLimiter::for('VKAlbumsUpdate', function (object $job) {
            return Limit::perSecond(3);
            // perMinute(2);
        });
    }
}
