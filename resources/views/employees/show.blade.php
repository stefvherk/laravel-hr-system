<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white shadow rounded-lg p-6">

                <h1 class="text-2xl font-bold mb-6">
                    {{  $employee->user->name }}
                </h1>

                <div class="space-y-3">
                    <p><strong>Email:</strong> {{ $employee->user->email }}</p>
                    <p><strong>Department:</strong> {{ $employee->department->name }}</p>
                    <p><strong>Position:</strong> {{ $employee->position->title }}</p>
                    @if(auth()->user()->isAdmin() || auth()->user()->isHrManager())
                        <p>
                            <strong>Base salary:</strong>
                            €{{ number_format($employee->position->base_salary, 2) }}
                        </p>
                    @endif
                    <p><strong>Hire date:</strong> {{ $employee->hire_date }}</p>
                    <p><strong>Status:</strong> {{ $employee->employment_status }}</p>
                </div>

                @if(auth()->user()->isAdmin())

                    <div class="mt-8 border-t pt-6">
                        <h2 class="text-xl font-bold mb-4">
                            Change Password
                        </h2>

                        <form method="POST"
                            action="{{ route('employees.password.update', $employee) }}">

                            @csrf
                            @method('PATCH')

                            <div class="mb-4">
                                <label class="block mb-1">
                                    New Password
                                </label>

                                <input type="password"
                                    name="password"
                                    class="w-full border rounded p-2">

                                @error('password')
                                    <p class="text-red-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block mb-1">
                                    Confirm Password
                                </label>

                                <input type="password"
                                    name="password_confirmation"
                                    class="w-full border rounded p-2">
                            </div>

                            <button type="submit"
                                    class="bg-red-600 text-white px-4 py-2 rounded">
                                Update Password
                            </button>
                        </form>
                    </div>

                @endif

                <div class="mt-6">
                    <a href="{{  route('employees.index')}}"
                        class="text-blue-600 underline">
                            Back to employees
                    </a>
                </div>

            </div>
        
        </div>
    </div>
</x-app-layout>
