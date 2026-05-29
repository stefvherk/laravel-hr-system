<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
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

        $department = Department::firstOrCreate(
            ['name' => 'Administration'],
            ['description' => 'Default administration department']
        );

        $position = Position::firstOrCreate(
            ['title' => 'Administrator'],
            ['base_salary' => 0]
        );

        $user = User::firstOrCreate(
            ['email' => env('DEFAULT_ADMIN_EMAIL')],
            [
                'name' => env('DEFAULT_ADMIN_NAME', 'Default Admin'),
                'password' => Hash::make(env('DEFAULT_ADMIN_PASSWORD')),
                'role' => 'admin',
            ]
        );

        Employee::firstOrCreate(
            ['user_id' => $user->id],
            [
                'department_id' => $department->id,
                'position_id' => $position->id,
                'hire_date' => now(),
                'employment_status' => 'active',
            ]
        );
    }
}
