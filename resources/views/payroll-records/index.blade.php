<x-app-layout>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6">

                <div class="flex justify-between items-center mb-6">

                    <h1 class="text-2xl font-bold">
                        Payroll Records
                    </h1>

                    @if(auth()->user()->isAdmin() || auth()->user()->isHrManager())
                        <a href="{{ route('payroll-records.create') }}"
                        class="bg-blue-500 text-white px-4 py-2 rounded">
                            Add Payroll
                        </a>
                    @endif

                </div>

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
                            <th class="text-left p-2">Period</th>
                            <th class="text-left p-2">Base</th>
                            <th class="text-left p-2">Bonus</th>
                            <th class="text-left p-2">Deductions</th>
                            <th class="text-left p-2">Net Salary</th>
                        </tr>
                    </thead>

                    <tbody>

                    @foreach($payrollRecords as $record)

                        <tr class="border-b">

                            <td class="p-2">
                                {{ $record->employee->user->name }}
                            </td>

                            <td class="p-2">
                                {{ $record->pay_period }}
                            </td>

                            <td class="p-2">
                                €{{ number_format($record->base_salary, 2) }}
                            </td>

                            <td class="p-2">
                                €{{ number_format($record->bonus, 2) }}
                            </td>

                            <td class="p-2">
                                €{{ number_format($record->deductions, 2) }}
                            </td>

                            <td class="p-2 font-bold">
                                €{{ number_format($record->netSalary(), 2) }}
                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

                <div class="mt-4">
                    {{ $payrollRecords->links() }}
                </div>

            </div>

        </div>
    </div>

</x-app-layout>