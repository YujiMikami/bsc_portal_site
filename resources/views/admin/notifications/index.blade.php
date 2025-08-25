<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            お知らせ管理
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
                    @if (session('error'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded relative" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="flex justify-start mb-4">
                        <a href="{{ route('admin.notification.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mx-2 rounded focus:outline-none focus:shadow-outline">
                            お知らせ登録
                        </a>
                    </div>
                    <table class="table-auto border jQ-table">
                        <thead>
                            <tr>
                                @if ($notifications->isEmpty())
                                    お知らせがありません。
                                @else
                                    <th class="border px-4 py-2">タイトル</th>
                                    <th class="border px-4 py-2">公開日時</th>
                                    <th class="border px-4 py-2">終了日時</th>
                                    <th class="border px-4 py-2">操作</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($notifications as $val)
                            <tr>
                                <td class="border px-4 py-2">{{ $val->title  }}</td>
                                <td class="border px-4 py-2">{{ $val->start_at }}</td>
                                <td class="border px-4 py-2">{{ $val->end_at }}</td>
                                <td class="border px-4 py-2">
                                    <div class="flex items-center space-x-4">
                                        {{-- 詳細ボタンを追加 --}}
                                        <a href="{{ route('admin.notification.show', $val->id) }}" class="ml-2 text-blue-600 hover:underline">詳細</a>
                                        @if ($val->start_at > now())
                                        {{-- 編集ボタンを追加 --}}
                                        <a href="{{ route('admin.notification.edit', $val->id) }}" class="ml-2 text-green-600 hover:underline">編集</a>
                                        @endif
                                        {{-- 未読者一覧ボタンを追加 --}}
                                        <a href="{{ route('admin.notification.unread', $val->id) }}" class="ml-2 text-orange-600 hover:underline">未読者一覧</a>
                                        {{-- 削除ボタンの追加 --}}
                                        <form action="{{ route('admin.notification.delete', $val->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
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