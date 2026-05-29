<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Employee::with([
            'user',
            'department',
            'position'
        ]);

        if (auth()->user()->isEmployee()) {
            $query->where('employment_status', '!=', 'inactive');
        }

        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('department')) {
            $query->where('department_id', $request->department);
        }

        if (
            $request->filled('status')
            && (
                auth()->user()->isAdmin()
                || auth()->user()->isHrManager()
                || $request->status !== 'inactive'
            )
        ) {
            $query->where('employment_status', $request->status);
        }

        $employees = $query->paginate(10)->withQueryString();

        $departments = Department::all();

        return view('employees.index', compact(
            'employees',
            'departments'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_unless(
            auth()->user()->isAdmin()
            || auth()->user()->isHrManager(),
            403
        );
        $departments = Department::all();
        $positions = Position::all();

        return view('employees.create', compact('departments', 'positions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        abort_unless(
            auth()->user()->isAdmin()
            || auth()->user()->isHrManager(),
            403
        );

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password'),
        ]);

        Employee::create([
            'user_id' => $user->id,
            'department_id' => $request->department_id,
            'position_id' => $request->position_id,
            'hire_date' => $request->hire_date,
            'employment_status' => $request->employment_status,
        ]);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $employee->load(['user', 'department', 'position']);
        
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        abort_unless(
            auth()->user()->isAdmin()
            || auth()->user()->isHrManager(),
            403
        );

        $departments = Department::all();
        $positions = Position::all();

        $employee->load(['user', 'department', 'position']);

        return view('employees.edit', compact(
            'employee',
            'departments',
            'positions'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateEmployeeRequest $request,
        Employee $employee
    ) {
        abort_unless(
            auth()->user()->isAdmin()
            || auth()->user()->isHrManager(),
            403
        );
        $employee->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $employee->update([
            'department_id' => $request->department_id,
            'position_id' => $request->position_id,
            'hire_date' => $request->hire_date,
            'employment_status' => $request->employment_status,
        ]);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee updated successfully.');
        }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        abort_unless(
            auth()->user()->isAdmin()
            || auth()->user()->isHrManager(),
            403
        );
        $employee->user->delete();

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee deleted successfully.');
    }

    public function updatePassword(
        UpdateUserPasswordRequest $request,
        Employee $employee
    ) {
        $employee->user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('employees.show', $employee)
            ->with('success', 'Password updated successfully.');
    }
}
