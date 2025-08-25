<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            未読者一覧
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 flex">
                        <a href="{{ route('admin.notification.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 mr-4 rounded focus:outline-none focus:shadow-outline">
                            戻る
                        </a>
                    </div>
                    <table class="table-auto w-full border">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">社員番号</th>
                                <th class="border px-4 py-2">社員名</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($unreadEmployees as $val)
                                <tr>
                                    <td class="border px-4 py-2">{{ $val->employee_id }}</td>
                                    <td class="border px-4 py-2">{{ $val->employee_name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

