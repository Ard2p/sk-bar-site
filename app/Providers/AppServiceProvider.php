<?php

namespace App\Providers;

// use Jenssegers\Date;

use App\Helpers\UtmHelper;
use App\Models\User;
use App\Models\Domain;
use Illuminate\Support\Facades\DB;
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
        // Регистрируем UtmHelper как singleton
        $this->app->singleton(UtmHelper::class, function ($app) {
            return new UtmHelper();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        UtmHelper::registerBladeDirective();

        if (!app()->runningInConsole() || !str_contains(implode(' ', $_SERVER['argv'] ?? []), 'migrate')) {
            config(['domain.places' => $this->getPlacesByDomain()]);
        }

        Paginator::useBootstrap();

        Gate::define('viewPulse', function (User $user) {
            return $user->id > 0;
        });

        RateLimiter::for('VKAlbumsUpdate', function (object $job) {
            return Limit::perSecond(3);
            // perMinute(2);
        });
    }

    protected function getPlacesByDomain()
    {
        $domain = request()->getHost();
        $domain = Domain::domain($domain)->first();
        $placesIds = $domain?->places()->allRelatedIds()->toArray();
        // dd($placesIds ?? []);
        return $placesIds;
    }
}
