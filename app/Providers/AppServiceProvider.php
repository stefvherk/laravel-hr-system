<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
        if (app()->runningInConsole()) {
            return;
        }

        User::firstOrCreate(
            ['email' => env('DEFAULT_ADMIN_EMAIL')],
            [
                'name' => env('DEFAULT_ADMIN_NAME', 'Default Admin'),
                'password' => Hash::make(env('DEFAULT_ADMIN_PASSWORD')),
                'role' => 'admin',
            ]
        );
    }
}
