<x-app-layout>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6">

                <h1 class="text-2xl font-bold mb-6">
                    Add Payroll Record
                </h1>

                <form method="POST"
                      action="{{ route('payroll-records.store') }}">

                    @csrf

                    <div class="mb-4">

                        <label class="block mb-1">
                            Employee
                        </label>

                        <select name="employee_id"
                                class="w-full border rounded p-2 pr-10">

                            @foreach($employees as $employee)

                                <option value="{{ $employee->id }}"
                                    @selected(old('employee_id') == $employee->id)>

                                    {{ $employee->user->name }}
                                    —
                                    {{ $employee->position->title }}

                                </option>

                            @endforeach

                        </select>

                        @error('employee_id')

                            <p class="text-red-600 text-sm">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>

                    <div class="mb-4">

                        <label class="block mb-1">
                            Pay Period
                        </label>

                        <input type="date"
                               name="pay_period"
                               value="{{ old('pay_period') }}"
                               class="w-full border rounded p-2">

                        @error('pay_period')

                            <p class="text-red-600 text-sm">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>

                    <div class="mb-4">

                        <label class="block mb-1">
                            Base Salary
                        </label>

                        <input type="number"
                               step="0.01"
                               name="base_salary"
                               value="{{ old('base_salary') }}"
                               class="w-full border rounded p-2">

                        @error('base_salary')

                            <p class="text-red-600 text-sm">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>

                    <div class="mb-4">

                        <label class="block mb-1">
                            Bonus
                        </label>

                        <input type="number"
                               step="0.01"
                               name="bonus"
                               value="{{ old('bonus', 0) }}"
                               class="w-full border rounded p-2">

                        @error('bonus')

                            <p class="text-red-600 text-sm">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>

                    <div class="mb-6">

                        <label class="block mb-1">
                            Deductions
                        </label>

                        <input type="number"
                               step="0.01"
                               name="deductions"
                               value="{{ old('deductions', 0) }}"
                               class="w-full border rounded p-2">

                        @error('deductions')

                            <p class="text-red-600 text-sm">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>

                    <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded">

                        Create Payroll Record

                    </button>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>