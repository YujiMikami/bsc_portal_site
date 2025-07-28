<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            職種テーブル
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
                        <a href="{{ route('admin.table.occupations.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            職種登録
                        </a>
                    </div>
                    <div class="p-6 text-gray-900">
                </div>
                    <div class="flex justify-start mb-4">
                    </div>
                    <table class="table-auto w-full border jQ-table">
                        <thead>
                            <tr>
                                @if ($occupations->isEmpty())
                                    職種登録がありません。
                                @else
                                    <th class="border px-4 py-2">職種ID</th>
                                    <th class="border px-4 py-2">職種名</th>
                                    <th class="border px-4 py-2">操作</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($occupations as $val)
                            <tr>
                                <td class="border px-4 py-2">{{ $val->occupation_id  }}</td>
                                <td class="border px-4 py-2">{{ $val->occupation_name }}</td>
                                <td class="border px-4 py-2">
                                    {{-- 詳細ボタンを追加 --}}
                                    <a href="{{ route('admin.table.occupations.show', $val->occupation_id) }}" class="text-blue-600 hover:underline">詳細</a>
                                    {{-- 編集ボタンを追加 --}}
                                    <a href="{{ route('admin.table.occupations.edit', $val->occupation_id) }}" class="ml-2 text-green-600 hover:underline">編集</a>
                                    {{-- 削除ボタンの追加 --}}
                                    <form action="{{ route('admin.table.occupations.delete', $val->occupation_id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline bg-transparent border-none cursor-pointer p-0 m-0">削除</button>
                                    </form>
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