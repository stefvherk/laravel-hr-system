<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">

                <h1 class="text-2xl font-bold mb-6">Add Employee</h1>

                <form method="POST" 
                    action="{{ route('employees.update', $employee) }}">

                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block mb-1">Name</label>
                        <input type="text" name="name" value="{{ old('name', $employee->user->name) }}" class="w-full border rounded p-2">
                        @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $employee->user->email) }}" class="w-full border rounded p-2">
                        @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Department</label>
                        <select name="department_id" class="w-full border rounded p-2">
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" 
                                    @selected(old('department_id', $employee->department_id) == $department->id)>
                                    {{ $department->name }} 
                                </option>
                            @endforeach
                        </select>
                        @error('department_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Position</label>
                        <select name="position_id" class="w-full border rounded p-2">
                            @foreach($positions as $position)
                                <option value="{{ $position->id }}" 
                                    @selected(old('position_id', $employee->position_id) == $position->id)>
                                    {{ $position->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('position_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Hire Date</label>
                        <input type="date" name="hire_date" value="{{ old('hire_date', $employee->hire_date) }}" class="w-full border rounded p-2">
                        @error('hire_date') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block mb-1">Status</label>
                        <select name="employment_status" class="w-full border rounded p-2">
                            <option value="active" 
                                @selected(old('employment_status', $employee->employment_status) === 'active')>Active</option>
                            <option value="inactive" 
                                @selected(old('employment_status', $employee->employment_status) === 'inactive')>Inactive</option>
                            <option value="on_leave" 
                                @selected(old('employment_status', $employee->employment_status) === 'on_leave')>On Leave</option>
                        </select>
                        @error('employment_status') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                        Update Employee
                    </button>

                    <a href="{{ route('employees.index') }}" class="ml-3 text-gray-600 underline">
                        Cancel
                    </a>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>