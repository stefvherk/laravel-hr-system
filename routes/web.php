<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaveRequestController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::resource('employees', \App\Http\Controllers\EmployeeController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
    
    Route::resource('leave-requests',
        \App\Http\Controllers\LeaveRequestController::class);
    
    Route::patch(
        '/leave-requests/{leaveRequest}/approve',
        [\App\Http\Controllers\LeaveRequestController::class, 'approve']
    )->name('leave-requests.approve');

    Route::patch(
        '/leave-requests/{leaveRequest}/reject',
        [\App\Http\Controllers\LeaveRequestController::class, 'reject']
    )->name('leave-requests.reject');

    Route::resource(
        'attendance-records',
        \App\Http\Controllers\AttendanceRecordController::class
    );

    Route::resource(
        'payroll-records',
        \App\Http\Controllers\PayrollRecordController::class
    );

    Route::patch(
        '/employees/{employee}/password',
        [EmployeeController::class, 'updatePassword']
    )->name('employees.password.update');

    Route::patch(
        '/leave-requests/{leaveRequest}/cancel',
        [LeaveRequestController::class, 'cancel']
    )->name('leave-requests.cancel');
});

require __DIR__.'/auth.php';
