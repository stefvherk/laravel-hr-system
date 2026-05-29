<?php

namespace Database\Seeders;

use App\Models\User;
Use App\Models\Department;
use App\Models\Position;
use App\Models\AttendanceRecord;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\PayrollRecord;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Department::factory()->count(6)->create();
        Position::factory()->count(7)->create();

        //Default gebruikers, passwords echo'd na seeding.
        $adminPassword = Str::password(16);
        $hrPassword = Str::password(16);
        $employeePassword = Str::password(16);

        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make($adminPassword),
            'role' => 'admin',
        ]);

        Employee::create([
            'user_id' => $adminUser->id,
            'department_id' => Department::first()->id,
            'position_id' => Position::first()->id,
            'hire_date' => now(),
            'employment_status' => 'active',
        ]);

        $hrUser = User::create([
            'name' => 'HR Manager',
            'email' => 'hr@example.com',
            'password' => Hash::make($hrPassword),
            'role' => 'hr_manager',
        ]);

        Employee::create([
            'user_id' => $hrUser->id,
            'department_id' => Department::first()->id,
            'position_id' => Position::first()->id,
            'hire_date' => now(),
            'employment_status' => 'active',
        ]);

        $employeeUser = User::create([
            'name' => 'Regular Employee',
            'email' => 'employee@example.com',
            'password' => Hash::make($employeePassword),
            'role' => 'employee',
        ]);

        Employee::create([
            'user_id' => $employeeUser->id,
            'department_id' => Department::first()->id,
            'position_id' => Position::first()->id,
            'hire_date' => now(),
            'employment_status' => 'active',
        ]);
        //Einde default gebruikers

        Employee::factory()
            ->count(25)
            ->make()
            ->each(function ($employee) {
            
                $employee->department_id =
                    \App\Models\Department::inRandomOrder()->first()->id;

                $employee->position_id =
                    \App\Models\Position::inRandomOrder()->first()->id;

                $employee->save();
            });

        //Realistische data voor leave requests, attendance records en payroll records
        $employees = Employee::with('position')->get();

        $employees->each(function ($employee) {

        // Geef employees met 'on_leave' status een actieve leave request
        if ($employee->employment_status === 'on_leave') {
                LeaveRequest::factory()->create([
                    'employee_id' => $employee->id,
                    'start_date' => now()->subDays(rand(1, 5))->format('Y-m-d'),
                    'end_date' => now()->addDays(rand(2, 10))->format('Y-m-d'),
                    'status' => 'approved',
                    'reason' => 'Approved current leave',
                ]);
            }
            
            // Alle employees krijgen 1-2 leave requests, sommige goedgekeurd, andere in afwachting
            LeaveRequest::factory()
                ->count(rand(1, 2))
                ->create([
                    'employee_id' => $employee->id,
                ]);
        });

        $employees->each(function ($employee) {

            $approvedLeaveRequests = $employee->leaveRequests()
                ->where('status', 'approved')
                ->get();

            for ($i = 0; $i < 60; $i++) {
                $date = Carbon::now()->subDays($i);

                if ($date->isWeekend()) {
                    continue;
                }

                $isOnApprovedLeave = $approvedLeaveRequests->contains(function ($leaveRequest) use ($date) {
                    return $date->between(
                        Carbon::parse($leaveRequest->start_date),
                        Carbon::parse($leaveRequest->end_date)
                    );
                });

                if ($isOnApprovedLeave) {
                    continue;
                }

                $checkIn = $date->copy()
                    ->setTime(rand(8, 9), rand(0, 45));

                $checkOut = $checkIn->copy()
                    ->addHours(rand(7, 9))
                    ->addMinutes(rand(0, 45));

                AttendanceRecord::factory()->create([
                    'employee_id' => $employee->id,
                    'check_in_at' => $checkIn,
                    'check_out_at' => $checkOut,
                ]);
            }
        });

        $employees->each(function ($employee) {
            for ($monthOffset = 0; $monthOffset < 3; $monthOffset++) {
                PayrollRecord::factory()->create([
                    'employee_id' => $employee->id,
                    'base_salary' => $employee->position->base_salary,
                    'pay_period' => now()
                        ->subMonths($monthOffset)
                        ->startOfMonth()
                        ->format('Y-m-d'),
                ]);
            }
        });

        $this->command->info('');
        $this->command->info('Demo account credentials:');
        $this->command->line("Admin: admin@example.com / {$adminPassword}");
        $this->command->line("HR Manager: hr@example.com / {$hrPassword}");
        $this->command->line("Employee: employee@example.com / {$employeePassword}");
        $this->command->info('');
    }
}
