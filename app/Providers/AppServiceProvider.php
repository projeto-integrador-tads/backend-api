<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;

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
        //
        /*
            // personalizar o link que redireciona para resetar a senha
            ResetPassword::createUrlUsing(function (User $user, string $token) {
                return 'https://example.com/reset-password?token='.$token;
            });
        */
    }
}
