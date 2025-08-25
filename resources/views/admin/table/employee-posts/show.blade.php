<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            役職詳細（ID: {{ $employeePost->employee_post_id }}）
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 text-gray-900">
                        <a href="{{ route('admin.table.employee-posts.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            戻る
                        </a>
                    </div>
                    <p class="mb-2">役職ID:{{ $employeePost->employee_post_id }}</p>
                    <p class="mb-2">役職名:{{ $employeePost->employee_post_name }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

