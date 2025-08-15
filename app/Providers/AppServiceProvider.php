<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        Blade::if('can', function ($permissions) {
            $user = Auth::user();

            if (!$user) {
                return false;
            }

            if ($user->hasRole('super admin')) {
                return true;
            }

            // Convert string to array if needed
            if (is_string($permissions)) {
                $permissions = [$permissions];
            }

            return $user->hasAnyPermission($permissions);
        });
    }
}
