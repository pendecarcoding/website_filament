<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;

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
        \Filament\Facades\Filament::serving(function () {
            $user = auth()->user();
            if ($user) {
                Log::info('Filament serving user:', [
                    'id' => $user->id,
                    'roles' => $user->getRoleNames(),
                    'is_superadmin' => $user->is_superadmin ?? false,
                    'permissions' => $user->getAllPermissions()->pluck('name'),
                ]);
            }
        });
    }
}
