<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            ＰＣ貸与テーブル
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
                        <div class="mb-4 p-4 bg-red-100 border border-green-400 text-green-700 rounded relative" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="flex justify-start mb-4">
                        <a href="{{ route('admin.table.pc-loans.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mx-2 rounded focus:outline-none focus:shadow-outline">
                            貸与登録
                        </a>
                    </div>
                    <table class="table-auto border jQ-table">
                        <thead>
                            <tr>
                                @if ($pcLoans->isEmpty())
                                    貸与登録がありません。
                                @else
                                    <th class="border px-4 py-2">ID</th>
                                    <th class="border px-4 py-2">貸与者氏名</th>
                                    <th class="border px-4 py-2">ＰＣナンバー</th>
                                    <th class="border px-4 py-2">操作</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pcLoans as $val)
                                <tr>
                                    <td class="border px-4 py-2">{{ $val->id }}</td>
                                    <td class="border px-4 py-2">{{ $val->employee_name }}</td>
                                    <td class="border px-4 py-2">{{ $val->pc_number }}</td>
                                    <td class="border px-4 py-2">
                                        <div class="flex items-center space-x-4">
                                            {{-- 詳細ボタン --}}
                                            <a href="{{ route('admin.table.pc-loans.show', $val->id) }}" class="text-blue-600 hover:underline">詳細</a>
                                            {{-- 編集ボタン --}}
                                            <a href="{{ route('admin.table.pc-loans.edit', $val->id) }}" class="text-green-600 hover:underline">編集</a>
                                            {{-- 削除ボタン --}}
                                            <form action="{{ route('admin.table.pc-loans.delete', $val->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline bg-transparent border-none cursor-pointer p-0 m-0">
                                                    削除
                                                </button>
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