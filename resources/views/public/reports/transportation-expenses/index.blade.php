<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            交通費申請
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
                        <a href="{{ route('public.reports.transportation-expenses.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            交通費申請
                        </a>
                    </div>
                    <table class="table-auto w-full border">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">作成日</th>
                                <th class="border px-4 py-2">申請日(予定日)</th>
                                <th class="border px-4 py-2">申請者ID</th>
                                <th class="border px-4 py-2">申請者名</th>
                                <th class="border px-4 py-2">合計金額</th>
                                <th class="border px-4 py-2">状態</th>
                                <th class="border px-4 py-2">承認者</th>
                                <th class="border px-4 py-2">受理者</th>
                                <th class="border px-4 py-2">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($expensesByDate->count() === 0)
                                <td colspan="6">交通費申請はありません。</td>
                            @else
                                @foreach ($expensesByDate as $submittedDate => $expenses)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $expenses->first()->created_at->format('Y-m-d') }}</td>
                                        @foreach ($expenses as $expense)
                                            @if ($loop->first)
                                                <td class="border px-4 py-2">{{ explode('_', $submittedDate)[0] }}</td>
                                                <td class="border px-4 py-2">{{ $expense->employee_id }}</td>
                                                <td class="border px-4 py-2">{{ $expense->EmployeeAccount->employee_name }}</td>
                                                <td class="border px-4 py-2">{{ number_format($expenses->sum('amount')) }}円</td>
                                                <td class="border px-4 py-2">
                                                    @if ($expense->recipient)
                                                        受理済み
                                                    @elseif ($expense->approver)
                                                        承認済み
                                                    @elseif ($expense->submitted)
                                                        申請済み
                                                    @else
                                                        保存済み
                                                    @endif
                                                </td>
                                                <td class="border px-4 py-2">{{ $expense->approver ?? '' }}</td>
                                                <td class="border px-4 py-2">{{ $expense->recipient ?? '' }}</td>
                                                <td class="border px-4 py-2">
                                                    <div class="flex flex-col space-y-2 sm:flex-row sm:space-x-4 sm:space-y-0">
                                                        {{-- 詳細ボタンを追加 --}}
                                                        <a href="{{ route('public.reports.transportation-expenses.show', ['id' => $expense->employee_id, 'date' => explode('_', $submittedDate)[0]]) }}" class="text-blue-600 hover:underline">詳細</a>
                                                        {{-- 編集ボタンを追加 --}}
                                                        @can('view', $expense) {{-- policyを使って制御 --}}
                                                            @if (empty($expense->submitted))
                                                                <a href="{{ route('public.reports.transportation-expenses.edit', ['id' => $expense->employee_id, 'date' => explode('_', $submittedDate)[0]]) }}" class="text-green-600 hover:underline">編集</a>
                                                                {{-- 削除ボタンを追加 --}}
                                                                <form action="{{ route('public.reports.transportation-expenses.delete', ['id' => $expense->employee_id, 'date' => explode('_', $submittedDate)[0]]) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="text-red-600 hover:underline bg-transparent border-none cursor-pointer p-0 m-0">削除</button>
                                                                </form>
                                                            @endif
                                                        @endcan
                                                        @can('approval', $expense)
                                                            @if (empty($expense->approver))
                                                                <form action="{{ route('public.reports.transportation-expenses.approval', ['id' => $expense->employee_id, 'date' => explode('_', $submittedDate)[0]]) }}" method="POST" onsubmit="return confirm('有給申請を許可しますか？');">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <button type="submit" class="text-red-600 hover:underline bg-transparent border-none cursor-pointer p-0 m-0">承認</button>
                                                                </form>
                                                            @endif
                                                                @endcan                                        
                                                        @can('acceptance', $expense)
                                                            @if (isset($expense->approver) && empty($expense->recipient))
                                                                <form action="{{ route('public.reports.transportation-expenses.acceptance', ['id' => $expense->employee_id, 'date' => explode('_', $submittedDate)[0]]) }}" method="POST" onsubmit="return confirm('有給申請を受理しますか？');">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <button type="submit" class="text-red-600 hover:underline bg-transparent border-none cursor-pointer p-0 m-0">受理</button>
                                                                </form>
                                                            @endif
                                                        @endcan
                                                    </div>  
                                                </td>
                                            @endif    
                                        @endforeach
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