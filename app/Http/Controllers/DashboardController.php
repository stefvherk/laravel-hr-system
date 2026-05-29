<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->isEmployee()) {
            $employee = auth()->user()->employee;

            return view('dashboard', [
                'personalLeaveRequests' => $employee->leaveRequests()->count(),
                'pendingLeaveRequests' => $employee->leaveRequests()->where('status', 'pending')->count(),
                'attendanceRecords' => $employee->attendanceRecords()->count(),
                'payrollRecords' => $employee->payrollRecords()->count(),
            ]);
        }

        return view('dashboard', [
            'totalEmployees' => \App\Models\Employee::count(),
            'activeEmployees' => \App\Models\Employee::where('employment_status', 'active')->count(),
            'employeesOnLeave' => \App\Models\Employee::where('employment_status', 'on_leave')->count(),
            'departmentCount' => \App\Models\Department::count(),
        ]);
    }
}