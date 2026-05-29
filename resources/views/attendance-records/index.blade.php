<x-app-layout>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6">

                <div class="flex justify-between items-center mb-6">

                    <h1 class="text-2xl font-bold">
                        Attendance Records
                    </h1>

                    @if(auth()->user()->isAdmin()
                        || auth()->user()->isHrManager())

                        <a href="{{ route('attendance-records.create') }}"
                        class="bg-blue-500 text-white px-4 py-2 rounded">

                            Add Attendance

                        </a>

                    @endif

                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                
                <form method="GET"
                    action="{{ route('attendance-records.index') }}"
                    class="mb-6 flex flex-wrap gap-4 items-center">

                    @if(auth()->user()->isAdmin() || auth()->user()->isHrManager())
                        <input type="text"
                            name="search"
                            placeholder="Search employee..."
                            value="{{ request('search') }}"
                            class="border rounded px-3 py-2">
                    @endif

                    <input type="date"
                        name="date"
                        value="{{ request('date') }}"
                        class="border rounded px-3 py-2">

                    <button type="submit"
                            class="bg-gray-800 text-white px-4 py-2 rounded">
                        Filter
                    </button>

                    <a href="{{ route('attendance-records.index') }}"
                    class="text-gray-600 underline">
                        Reset
                    </a>

                </form>

                <table class="w-full border-collapse">

                    <thead>
                        <tr class="border-b">
                            <th class="text-left p-2">Employee</th>
                            <th class="text-left p-2">Date</th>
                            <th class="text-left p-2">Check In</th>
                            <th class="text-left p-2">Check Out</th>
                            <th class="text-left p-2">Hours</th>
                        </tr>
                    </thead>

                    <tbody>

                    @foreach($attendanceRecords as $record)

                        <tr class="border-b">

                            <td class="p-2">
                                {{ $record->employee->user->name }}
                            </td>

                            <td class="p-2">
                                {{ \Carbon\Carbon::parse($record->check_in_at)->format('Y-m-d') }}
                            </td>

                            <td class="p-2">
                                {{ \Carbon\Carbon::parse($record->check_in_at)->format('H:i') }}
                            </td>

                            <td class="p-2">
                                {{ $record->check_out_at ? \Carbon\Carbon::parse($record->check_out_at)->format('Y-m-d H:i') : 'Still working' }}
                            </td>

                            <td class="p-2">
                                {{ $record->workedHours() ?? '-' }}
                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

                <div class="mt-4">
                    {{ $attendanceRecords->links() }}
                </div>

            </div>

        </div>
    </div>

</x-app-layout>