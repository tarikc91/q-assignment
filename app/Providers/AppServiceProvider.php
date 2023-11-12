<?php

namespace App\Providers;

use App\Clients\Qss\Qss;
use App\Models\AuthUser;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AuthUser::class);
        $this->app->singleton(Qss::class, function() {
            return new Qss(session('qss_token') ?? null);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share the AuthUser with all views
        View::share('authUser', app(AuthUser::class));
    }
}
