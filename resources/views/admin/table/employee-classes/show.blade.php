<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            社員区分詳細（ID: {{ $employeeClass->employee_class_id }}）
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-2">区分ID:{{ $employeeClass->employee_class_id }}</p>
                    <p class="mb-2">区分名:{{ $employeeClass->employee_class_name }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

