<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            申請一覧
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
                    <h1 class="text-2xl">処理中有給申請</h1>
                    <table class="table-auto w-full border mb-10">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">申請日</th>
                                <th class="border px-4 py-2">開始日</th>
                                <th class="border px-4 py-2">処理状況</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($paidRequests->isEmpty())
                                <td colspan="3">有給申請はありません。</td>
                            @else
                                @foreach ($paidRequests as $val)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $val->application_date }}</td>
                                        <td class="border px-4 py-2">{{ $val->start_date }}</td>
                                        @if (isset($val->approver))
                                            <td class="border px-4 py-2">受理待機中</td>
                                        @else
                                            <td class="border px-4 py-2">承認待機中</td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                    <h1 class="text-2xl">処理中交通費申請</h1>
                    <table class="table-auto w-full border">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">申請日</th>
                                <th class="border px-4 py-2">金額</th>
                                <th class="border px-4 py-2">処理状況</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($transportationExpenses->isEmpty())
                                <td colspan="3">交通費申請はありません。</td>
                            @else
                                @foreach ($transportationExpenses as $date => $val)
                                <tr>
                                        <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($date)->format('Y-m-d') }}</td>
                                        <td class="border px-4 py-2">{{ $val->sum('amount') }}</td>
                                        @if (isset($val->approver))
                                            <td class="border px-4 py-2">受理待機中</td>
                                        @else
                                            <td class="border px-4 py-2">承認待機中</td>
                                        @endif
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