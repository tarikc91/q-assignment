<?php

namespace App\Providers;

use App\Models\AuthUser;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Clients\Qss\Client as QssClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AuthUser::class);
        $this->app->singleton(QssClient::class, function() {
            return new QssClient(session('qss_token') ?? null);
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
