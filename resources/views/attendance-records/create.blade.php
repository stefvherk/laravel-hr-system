<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">

                <h1 class="text-2xl font-bold mb-6">Add Attendance Record</h1>

                <form method="POST" action="{{ route('attendance-records.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block mb-1">Employee</label>

                        <select name="employee_id" class="w-full border rounded p-2 pr-10">
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" @selected(old('employee_id') == $employee->id)>
                                    {{ $employee->user->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('employee_id')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Work Date</label>

                        <input type="date"
                               name="work_date"
                               value="{{ old('work_date') }}"
                               class="w-full border rounded p-2">

                        @error('work_date')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Check In</label>

                        <input type="datetime-local"
                            name="check_in_at"
                            value="{{ old('check_in_at') }}"
                            class="w-full border rounded p-2">

                        @error('check_in')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block mb-1">Check Out</label>

                        <input type="datetime-local"
                            name="check_out_at"
                            value="{{ old('check_out_at') }}"
                            class="w-full border rounded p-2">

                        @error('check_out')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                        Create Attendance
                    </button>

                    <a href="{{ route('attendance-records.index') }}" class="ml-3 text-gray-600 underline">
                        Cancel
                    </a>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>