<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            有給リスト
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
                    @endif                    <div class="flex justify-start mb-4">
                        <a href="{{ route('public.reports.paid-requests.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            有給申請
                        </a>
                    </div>
                    <table class="table-auto w-full border">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">社員番号</th>
                                <th class="border px-4 py-2">申請者名</th>
                                <th class="border px-4 py-2">有給開始日</th>
                                <th class="border px-4 py-2">有給終了日</th>
                                <th class="border px-4 py-2">日数</th>
                                <th class="border px-4 py-2">処理状況</th>
                                <th class="border px-4 py-2">承認者</th>
                                <th class="border px-4 py-2">受理者</th>
                                <th class="border px-4 py-2">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($paidRequests->isEmpty())
                                <td colspan="6">有給申請はありません。</td>
                            @else
                                @foreach ($paidRequests as $val)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $val->employee_id }}</td>
                                        <td class="border px-4 py-2">{{ $val->employee_name }}</td>
                                        <td class="border px-4 py-2">{{ $val->start_date }}</td>
                                        <td class="border px-4 py-2">{{ $val->end_date }}</td>
                                        <td class="border px-4 py-2">{{ $val->days }}</td>
                                        <td class="border px-4 py-2">
                                            @if (isset($val->recipient) && isset($val->approver))
                                                受理済み
                                            @elseif (isset($val->approver))
                                                受理待機中 
                                            @else
                                                承認待機中
                                            @endif
                                        </td>
                                        <td class="border px-4 py-2">{{ $val->approver }}</td>
                                        <td class="border px-4 py-2">{{ $val->recipient }}</td>
                                        <td class="border px-4 py-2">
                                            {{-- 詳細ボタンを追加 --}}
                                            <a href="{{ route('public.reports.paid-requests.show', $val->id) }}" class="text-blue-600 hover:underline">詳細</a>
                                            {{-- 編集ボタンを追加 --}}
                                            @can('view', $val) {{-- policyを使って制御 --}}
                                                <a href="{{ route('public.reports.paid-requests.edit', $val->id) }}" class="ml-2 text-green-600 hover:underline">編集</a>
                                                <form action="{{ route('public.reports.paid-requests.delete', $val->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:underline bg-transparent border-none cursor-pointer p-0 m-0">削除</button>
                                                </form>
                                            @endcan
                                            @can('approval', $val)
                                                @if (empty($val->approver))
                                                    <form action="{{ route('public.reports.paid-requests.approval', $val->id) }}" method="POST" onsubmit="return confirm('有給申請を許可しますか？');">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="text-red-600 hover:underline bg-transparent border-none cursor-pointer p-0 m-0">承認</button>
                                                    </form>
                                                @endif
                                                    @endcan                                        
                                            @can('acceptance', $val)
                                                @if (isset($val->approver) && empty($val->recipient))
                                                    <form action="{{ route('public.reports.paid-requests.acceptance', $val->id) }}" method="POST" onsubmit="return confirm('有給申請を受理しますか？');">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="text-red-600 hover:underline bg-transparent border-none cursor-pointer p-0 m-0">受理</button>
                                                    </form>
                                                @endif
                                            @endcan
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