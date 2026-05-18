<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\URL;

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
    // 🚀 Fuerza a Laravel a generar todas las rutas (CSS, JS, Links) con HTTPS en Render
    if (config('app.env') === 'production') {
        URL::forceScheme('https');
    }

    $this->configureDefaults();

    Fortify::redirects('register', function () {
        return match(auth()->user()->role) {
            'admin'  => '/admin/dashboard',
            'client' => '/client/dashboard',
            default  => '/',
        };
    });

    Fortify::redirects('login', function () {
        return match(auth()->user()->role) {
            'admin'  => '/admin/dashboard',
            'client' => '/client/dashboard',
            default  => '/',
        };
    });
}

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
