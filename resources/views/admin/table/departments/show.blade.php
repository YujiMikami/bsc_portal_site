<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            部署詳細（ID: {{ $department->department_id }}）
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 text-gray-900">
                        <a href="{{ route('admin.table.departments.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            戻る
                        </a>
                    </div>
                    <p class="mb-2">部署ID:{{ $department->department_id }}</p>
                    <p class="mb-2">部署名:{{ $department->department_name }}</p>
                    <p class="mb-2">説明:{{ $department->department_explanation }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

