<x-app-layout>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <h1 class="text-3xl font-bold mb-6">
                HR Dashboard
            </h1>

            @if(auth()->user()->isEmployee())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-gray-500 text-sm mb-2">My Leave Requests</h2>
                    <p class="text-3xl font-bold">{{ $personalLeaveRequests }}</p>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-gray-500 text-sm mb-2">Pending Leave</h2>
                    <p class="text-3xl font-bold">{{ $pendingLeaveRequests }}</p>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-gray-500 text-sm mb-2">Attendance Records</h2>
                    <p class="text-3xl font-bold">{{ $attendanceRecords }}</p>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-gray-500 text-sm mb-2">Payroll Records</h2>
                    <p class="text-3xl font-bold">{{ $payrollRecords }}</p>
                </div>
            </div>
            @else
            <!--Admin Dashboard-->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-gray-500 text-sm mb-2">
                        Total Employees
                    </h2>

                    <p class="text-3xl font-bold">
                        {{ $totalEmployees }}
                    </p>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-gray-500 text-sm mb-2">
                        Active Employees
                    </h2>

                    <p class="text-3xl font-bold text-green-600">
                        {{ $activeEmployees }}
                    </p>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-gray-500 text-sm mb-2">
                        Employees On Leave
                    </h2>

                    <p class="text-3xl font-bold text-yellow-600">
                        {{ $employeesOnLeave }}
                    </p>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-gray-500 text-sm mb-2">
                        Departments
                    </h2>

                    <p class="text-3xl font-bold text-blue-600">
                        {{ $departmentCount }}
                    </p>
                </div>

            </div>

            @endif

        </div>
    </div>

</x-app-layout>