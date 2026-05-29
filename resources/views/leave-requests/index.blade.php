<x-app-layout>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6">

                <div class="flex justify-between items-center mb-6">

                    <h1 class="text-2xl font-bold">
                        Leave Requests
                    </h1>

                    <a href="{{ route('leave-requests.create') }}"
                       class="bg-blue-500 text-white px-4 py-2 rounded">

                        Request Leave

                    </a>

                </div>
                <form method="GET"
                    action="{{ route('leave-requests.index') }}"
                    class="mb-6 flex flex-wrap gap-4 items-center">

                    @if(auth()->user()->isAdmin() || auth()->user()->isHrManager())
                        <input type="text"
                            name="search"
                            placeholder="Search employee..."
                            value="{{ request('search') }}"
                            class="border rounded px-3 py-2">
                    @endif

                    <input type="date"
                        name="start_date"
                        value="{{ request('start_date') }}"
                        class="border rounded px-3 py-2">

                    <select name="status"
                            class="border rounded px-3 py-2 pr-10">

                        <option value="">All Statuses</option>

                        <option value="pending" @selected(request('status') === 'pending')>
                            Pending
                        </option>

                        <option value="approved" @selected(request('status') === 'approved')>
                            Approved
                        </option>

                        <option value="rejected" @selected(request('status') === 'rejected')>
                            Rejected
                        </option>

                        <option value="cancelled" @selected(request('status') === 'cancelled')>
                            Cancelled
                        </option>
                        <option value="expired" @selected(request('status') === 'expired')>
                            Expired
                        </option>

                    </select>

                    <button type="submit"
                            class="bg-gray-800 text-white px-4 py-2 rounded">
                        Filter
                    </button>

                    <a href="{{ route('leave-requests.index') }}"
                    class="text-gray-600 underline">
                        Reset
                    </a>

                </form>
                @if(session('success'))

                    <div class="bg-green-100 border border-green-400
                                text-green-700 px-4 py-3 rounded mb-4">

                        {{ session('success') }}

                    </div>

                @endif
                <table class="w-full border-collapse">

                    <thead>
                        <tr class="border-b">
                            <th class="text-left p-2">Employee</th>
                            <th class="text-left p-2">Start</th>
                            <th class="text-left p-2">End</th>
                            <th class="text-left p-2">Reason</th>
                            <th class="text-left p-2">Status</th>
                            <th class="text-left p-2">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                    @foreach($leaveRequests as $leaveRequest)

                        <tr class="border-b">

                            <td class="p-2">
                                {{ $leaveRequest->employee->user->name }}
                            </td>

                            <td class="p-2">
                                {{ $leaveRequest->start_date }}
                            </td>

                            <td class="p-2">
                                {{ $leaveRequest->end_date }}
                            </td>

                            <td class="p-2 max-w-xs">
                                <div class="truncate"
                                    title="{{ $leaveRequest->reason }}">
                                    {{ $leaveRequest->reason }}
                                </div>
                            </td>

                            <td class="p-2">
                                <span class="
                                    @if($leaveRequest->status === 'approved')
                                        text-green-600
                                    @elseif($leaveRequest->status === 'rejected')
                                        text-red-600
                                    @elseif($leaveRequest->status === 'cancelled')
                                        text-gray-600
                                    @elseif($leaveRequest->status === 'expired')
                                        text-slate-500
                                    @else
                                        text-yellow-600
                                    @endif
                                ">

                                    {{ ucfirst($leaveRequest->status) }}

                                </span>
                            </td>

                            <td class="p-2 space-x-2">

                                @if(
                                    auth()->user()->isEmployee()
                                    && $leaveRequest->status === 'pending'
                                )
                                    <form method="POST"
                                        action="{{ route('leave-requests.cancel', $leaveRequest) }}"
                                        class="inline">

                                        @csrf
                                        @method('PATCH')

                                        <button type="submit"
                                                class="text-red-600 underline">
                                            Cancel
                                        </button>
                                    </form>
                                @endif

                                @if($leaveRequest->status === 'pending'
                                    && (
                                        auth()->user()->isAdmin()
                                        || auth()->user()->isHrManager()
                                    )
                                )

                                    <form method="POST"
                                        action="{{ route(
                                            'leave-requests.approve',
                                            $leaveRequest
                                        ) }}"
                                        class="inline">

                                        @csrf
                                        @method('PATCH')

                                        <button type="submit"
                                                class="text-green-600 underline">

                                            Approve

                                        </button>

                                    </form>

                                    <form method="POST"
                                        action="{{ route(
                                            'leave-requests.reject',
                                            $leaveRequest
                                        ) }}"
                                        class="inline">

                                        @csrf
                                        @method('PATCH')

                                        <button type="submit"
                                                class="text-red-600 underline">

                                            Reject

                                        </button>

                                    </form>

                                @endif

                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

                <div class="mt-4">
                    {{ $leaveRequests->links() }}
                </div>

            </div>

        </div>
    </div>

</x-app-layout>