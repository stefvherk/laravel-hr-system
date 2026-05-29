<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Http\Requests\StoreAttendanceRecordRequest;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = AttendanceRecord::with([
            'employee.user'
        ]);

        if (auth()->user()->isEmployee()) {
            $query->where(
                'employee_id',
                auth()->user()->employee->id
            );
        }

        if ($request->filled('date')) {
            $query->whereDate(
                'check_in_at',
                $request->date
            );
        }

        if (
            $request->filled('search')
            && (
                auth()->user()->isAdmin()
                || auth()->user()->isHrManager()
            )
        ) {
            $query->whereHas('employee.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $attendanceRecords = $query
            ->latest('check_in_at')
            ->paginate(10)
            ->withQueryString();

        return view('attendance-records.index', compact(
            'attendanceRecords'
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

        $employees = Employee::with('user')->get();

        return view('attendance-records.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttendanceRecordRequest $request)
    {
        abort_unless(
            auth()->user()->isAdmin()
            || auth()->user()->isHrManager(),
            403
        );

        AttendanceRecord::create($request->validated());

        return redirect()
            ->route('attendance-records.index')
            ->with('success', 'Attendance record created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AttendanceRecord $attendanceRecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AttendanceRecord $attendanceRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AttendanceRecord $attendanceRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttendanceRecord $attendanceRecord)
    {
        //
    }
}
