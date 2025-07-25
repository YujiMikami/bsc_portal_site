<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            社員詳細（ID: {{ $employee->employee_id }}）
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    @foreach ($employee->getAttributes() as $key=>$val)
                        @if ($key === 'password' || $key === 'remember_token')
                            @continue
                        @endif
                        <p class="mb-2">{{ __('employee-columns.' . $key) }}:{{ $val }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

