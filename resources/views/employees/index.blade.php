<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6">

                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">
                        Employees
                    </h1>

                    @if(auth()->user()->isAdmin()
                        || auth()->user()->isHrManager())

                    <a href="{{ route('employees.create') }}"
                        class="bg-blue-500 text-white px-4 py-2 rounded">
                            Add Employee
                    </a>

                    @endif
                </div>

                @if(session('success'))

                    <div class="bg-green-100 border border-green-400
                        text-green-700 px-4 py-3 rounded mb-4">
                        
                        {{ session('success') }}

                    </div>
                
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="GET"
                    action="{{ route('employees.index') }}"
                    class="mb-6 flex flex-wrap gap-4 items-center">
                    
                    <input type="text"`
                        name="search"
                        placeholder="Search employee..."
                        value="{{ request('search') }}"
                        class="border rounded px-3 py-2">

                    <select name="department"
                        class="border rounded px-3 py-2 pr-10">

                        <option value="">
                            All departments
                        </option>

                        @foreach($departments as $department)

                            <option value="{{ $department->id }}"
                                @selected(request('department') == $department->id)>

                                {{ $department->name }}

                            </option>

                        @endforeach
                    </select>

                    <select name="status"
                        class="border rounded px-3 py-2 pr-10">

                        <option value="">
                            All Statuses
                        </option>

                        <option value="active"
                            @selected(request('status') === 'active')>

                            Active

                        </option>

                        
                        @if(auth()->user()->isAdmin() || auth()->user()->isHrManager())
                            <option value="inactive" 
                                @selected(request('status') === 'inactive')>

                                Inactive
                                
                            </option>
                        @endif

                        <option value="on_leave"
                            @selected(request('status') === 'on_leave')>

                            On Leave

                        </option>

                    </select>

                    <button type="submit"
                        class="bg-gray-500 text-white px-4 py-2 rounded">

                            Filter

                    </button>

                    <a href="{{ route('employees.index') }}"
                    class="text-gray-600 underline">
                        Reset
                    </a>
                </form>

                <table class="w-full border-collapse">

                    <thead>
                        <tr class="border-b">
                            <th class="text-left p-2">Name</th>
                            <th class="text-left p-2">Department</th>
                            <th class="text-left p-2">Position</th>
                            <th class="text-left p-2">Status</th>
                            <th class="text-left p-2">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                    @foreach($employees as $employee)

                        <tr class="border-b">
                            
                            <td class="p-2">
                                {{ $employee->user->name }}
                            </td>

                            <td class="p-2">
                                {{ $employee->department->name }}
                            </td>

                            <td class="p-2">
                                {{ $employee->position->title }}
                            </td>

                            <td class="p-2">
                                {{ $employee->employment_status }}
                            </td>

                            <td class="p-2 space-x-2">
                                <a href="{{ route('employees.show', $employee) }}"
                                class="text-blue-600 underline">
                                    View
                                </a>
                                @if(auth()->user()->isAdmin()
                                    || auth()->user()->isHrManager())
                                    <a href="{{ route('employees.edit', $employee) }}"
                                    class="text-yellow-600 underline">
                                        Edit
                                    </a>
                                @endif

                                @if(auth()->user()->isAdmin()
                                    || auth()->user()->isHrManager())
                                    <form method="POST"
                                        action="{{ route('employees.destroy', $employee) }}"
                                        class="inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="text-red-600 underline"
                                                onclick="return confirm('Delete this employee?')">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </td>
                        
                        </tr>
                    @endforeach

                    </tbody>
                
                </table>

                <div class="mt-4">
                    {{ $employees->links() }}
                </div>

            </div>

        </div>
    </div>

</x-app-layout>