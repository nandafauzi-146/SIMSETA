<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Login;
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
        // Paksa penggunaan skema HTTPS di environment production
        if (config('app.env') === 'production' || app()->environment('production')) {
            URL::forceScheme('https');
        }

        // Blokir login untuk user yang is_active = false
        Event::listen(Login::class, function (Login $event) {
            $user = $event->user;
            if ($user instanceof User && !$user->is_active) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => ['Akun Anda telah dinonaktifkan. Silakan hubungi Super Admin.'],
                ]);
            }
        });
    }
}