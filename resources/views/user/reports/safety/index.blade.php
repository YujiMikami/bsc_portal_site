<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            安否報告
        </h2>
    </x-slot>
    <!DOCTYPE html>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded relative" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="flex justify-start mb-4">
                        <a href="{{ route('user.reports.safety.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            安否報告
                        </a>
                    </div>
                    <table class="table-auto w-full border">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">社員番号</th>
                                <th class="border px-4 py-2">投稿者名</th>
                                <th class="border px-4 py-2">安否状況</th>
                                <th class="border px-4 py-2">傷害度合</th>
                                <th class="border px-4 py-2">出社可否</th>
                                <th class="border px-4 py-2">投稿日</th>
                                <th class="border px-4 py-2">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if (empty($safety))
                            <td colspan="6">安否報告はありません。</td>
                        @else
                            @foreach ($safety as $val)
                                <tr>
                                    <td class="border px-4 py-2">{{ $val->safety_employee_id }}</td>
                                    <td class="border px-4 py-2">{{ $val->safety_employee_name }}</td>
                                    <td class="border px-4 py-2">{{ $val->safety_status }}</td>
                                    <td class="border px-4 py-2">{{ $val->injury_status }}</td>
                                    <td class="border px-4 py-2">{{ $val->can_work }}</td>
                                    <td class="border px-4 py-2">{{ $val->created_at }}</td>
                                    <td>
                                        <form action="{{ route('user.reports.safety.delete', $val->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline bg-transparent border-none cursor-pointer p-0 m-0">削除</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>