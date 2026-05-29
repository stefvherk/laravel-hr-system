<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Http\Requests\StoreLeaveRequest;
use Illuminate\Http\Request;


class LeaveRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        LeaveRequest::where('end_date', '<', today())
            ->whereIn('status', ['pending', 'approved'])
            ->update([
                'status' => 'expired',
            ]);
            
        $query = LeaveRequest::with([
            'employee.user'
        ]);

        if (auth()->user()->isEmployee()) {
            $query->where(
                'employee_id',
                auth()->user()->employee->id
            );
        }

        if (
            request()->filled('search')
            && (
                auth()->user()->isAdmin()
                || auth()->user()->isHrManager()
            )
        ) {
            $query->whereHas('employee.user', function ($q) {
                $q->where('name', 'like', '%' . request('search') . '%');
            });
        }

        if (request()->filled('start_date')) {
            $query->whereDate('start_date', request('start_date'));
        }

        if (request()->filled('status')) {
            $query->where('status', request('status'));
        }

        $leaveRequests = $query
            ->orderByRaw('ABS(julianday(start_date) - julianday(?))', [today()->toDateString()])
            ->paginate(10)
            ->withQueryString();

        return view('leave-requests.index', compact('leaveRequests'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('leave-requests.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLeaveRequest $request)
    {
        LeaveRequest::create([
            'employee_id' => auth()->user()->employee->id,

            'start_date' => $request->start_date,

            'end_date' => $request->end_date,

            'reason' => $request->reason,

            'status' => 'pending',
        ]);

        return redirect()
            ->route('leave-requests.index')
            ->with('success', 'Leave request submitted.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LeaveRequest $leaveRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeaveRequest $leaveRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LeaveRequest $leaveRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeaveRequest $leaveRequest)
    {
        //
    }

    public function approve(LeaveRequest $leaveRequest)
    {
        abort_unless(
            auth()->user()->isAdmin()
            || auth()->user()->isHrManager(),
            403
        );

        $leaveRequest->update([
            'status' => 'approved'
        ]);

        return redirect()
            ->route('leave-requests.index')
            ->with('success', 'Leave request approved.');
    }

    public function reject(LeaveRequest $leaveRequest)
    {
        abort_unless(
            auth()->user()->isAdmin()
            || auth()->user()->isHrManager(),
            403
        );

        $leaveRequest->update([
            'status' => 'rejected'
        ]);

        return redirect()
            ->route('leave-requests.index')
            ->with('success', 'Leave request rejected.');
    }

    public function cancel(LeaveRequest $leaveRequest)
    {
        abort_unless(
            auth()->user()->employee->id === $leaveRequest->employee_id,
            403
        );

        abort_if(
            $leaveRequest->status !== 'pending',
            403
        );

        $leaveRequest->update([
            'status' => 'cancelled',
        ]);

        return redirect()
            ->route('leave-requests.index')
            ->with('success', 'Leave request cancelled.');
    }
}
