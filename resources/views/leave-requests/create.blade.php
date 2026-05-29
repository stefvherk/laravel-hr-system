<x-app-layout>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6">

                <h1 class="text-2xl font-bold mb-6">
                    Request Leave
                </h1>

                <p class="text-sm text-gray-600 mb-4">
                    Note: Leave requests must be submitted at least 14 days in advance.
                </p>

                <form method="POST"
                      action="{{ route('leave-requests.store') }}">

                    @csrf

                    <div class="mb-4">
                        <label class="block mb-1">
                            Start Date
                        </label>

                        <input type="date"
                               name="start_date"
                               min="{{ now()->addDays(14)->toDateString() }}"
                               value="{{ old('start_date') }}"
                               class="w-full border rounded p-2">

                        @error('start_date')

                            <p class="text-red-600 text-sm">
                                {{ $message }}
                            </p>

                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">
                            End Date
                        </label>

                        <input type="date"
                               name="end_date"
                               value="{{ old('end_date') }}"
                               class="w-full border rounded p-2">

                        @error('end_date')

                            <p class="text-red-600 text-sm">
                                {{ $message }}
                            </p>

                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block mb-1">
                            Reason
                        </label>

                        <textarea name="reason"
                                rows="5"
                                maxlength="1000"
                                class="w-full border rounded p-2">{{ old('reason') }}</textarea>

                        @error('reason')

                            <p class="text-red-600 text-sm">
                                {{ $message }}
                            </p>

                        @enderror
                    </div>

                    <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded">

                        Submit Request

                    </button>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>