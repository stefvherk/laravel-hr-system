<?php

namespace App\Http\Controllers;

use App\Models\PayrollRecord;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Http\Requests\StorePayrollRecordRequest;

class PayrollRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = PayrollRecord::with([
            'employee.user'
        ]);

        if (auth()->user()->isEmployee()) {
            $query->where(
                'employee_id',
                auth()->user()->employee->id
            );
        }

        $payrollRecords = $query
            ->latest('pay_period')
            ->paginate(10);

        return view('payroll-records.index', compact(
            'payrollRecords'
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

        $employees = Employee::with([
            'user',
            'position'
        ])
        ->join('users', 'employees.user_id', '=', 'users.id')
        ->orderBy('users.name')
        ->select('employees.*')
        ->get();

        return view('payroll-records.create', compact(
            'employees'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePayrollRecordRequest $request)
    {
        abort_unless(
            auth()->user()->isAdmin()
            || auth()->user()->isHrManager(),
            403
        );

        PayrollRecord::create([
            'employee_id' => $request->employee_id,

            'pay_period' => $request->pay_period,

            'base_salary' => $request->base_salary,

            'bonus' => $request->bonus ?? 0,

            'deductions' => $request->deductions ?? 0,
        ]);

        return redirect()
            ->route('payroll-records.index')
            ->with('success', 'Payroll record created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PayrollRecord $payrollRecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PayrollRecord $payrollRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PayrollRecord $payrollRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PayrollRecord $payrollRecord)
    {
        //
    }
}
