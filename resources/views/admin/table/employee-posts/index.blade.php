<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            役職テーブル
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
                        <a href="{{ route('admin.table.employee-posts.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mx-2 rounded focus:outline-none focus:shadow-outline">
                            役職登録
                        </a>
                        <a href="{{ route('admin.table.employee-posts.importcsv') }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 mx-2 rounded focus:outline-none focus:shadow-outline">
                            CSVインポート
                        </a>
                    </div>
                    <div class="p-6 text-gray-900">
                </div>
                    <div class="flex justify-start mb-4">
                    </div>
                    <table class="table-auto border jQ-table">
                        <thead>
                            <tr>
                                @if ($employeePosts->isEmpty())
                                    役職登録がありません。
                                @else
                                    <th class="border px-4 py-2">役職ID</th>
                                    <th class="border px-4 py-2">役職名</th>
                                    <th class="border px-4 py-2">操作</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($employeePosts as $val)
                            <tr>
                                <td class="border px-4 py-2">{{ $val->employee_post_id  }}</td>
                                <td class="border px-4 py-2">{{ $val->employee_post_name }}</td>
                                <td class="border px-4 py-2">
                                    <div class="flex items-center space-x-4">
                                        {{-- 詳細ボタンを追加 --}}
                                        <a href="{{ route('admin.table.employee-posts.show', $val->employee_post_id) }}" class="text-blue-600 hover:underline">詳細</a>
                                        {{-- 編集ボタンを追加 --}}
                                        <a href="{{ route('admin.table.employee-posts.edit', $val->employee_post_id) }}" class="ml-2 text-green-600 hover:underline">編集</a>
                                        {{-- 削除ボタンの追加 --}}
                                        <form action="{{ route('admin.table.employee-posts.delete', $val->employee_post_id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline bg-transparent border-none cursor-pointer p-0 m-0">削除</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>