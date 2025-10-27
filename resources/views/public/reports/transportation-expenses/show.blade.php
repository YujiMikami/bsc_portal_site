<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            交通費詳細
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 flex">
                        <a href="{{ route('public.reports.transportation-expenses.index') }}"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 mr-4 rounded focus:outline-none focus:shadow-outline">
                            戻る
                        </a>
                        @can('view', $transportationExpenses->first()) {{-- policyを使って制御 --}}
                            @if (empty($transportationExpenses->first()->submitted))
                                <a href="{{ route('public.reports.transportation-expenses.edit', ['id' => $transportationExpenses->first()->employee_id, 'date' => $transportationExpenses->first()->applied_date->format('Y-m-d')]) }}"
                                    class="mr-3 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    編集
                                </a>
                                <form action="{{ route('public.reports.transportation-expenses.store') }}" method="POST"
                                    onsubmit="return confirm('申請しますか？')">
                                    @csrf
                                    <input type="hidden" name="applied_date"
                                        value="{{ $transportationExpenses->first()->applied_date->format('Y-m-d') }}">
                                    @foreach ($transportationExpenses as $expense)
                                        <input type="hidden" name="expense_id[]" value="{{ $expense->id }}">
                                        <input type="hidden" name="use_date[]"
                                            value="{{ $expense->use_date->format('Y-m-d') }}">
                                        <input type="hidden" name="route_start[]" value="{{ $expense->route_start }}">
                                        <input type="hidden" name="route_end[]" value="{{ $expense->route_end }}">
                                        <input type="hidden" name="amount[]" value="{{ $expense->amount }}">
                                    @endforeach
                                    <input type="submit" name="action" value="申請"
                                        class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                </form>
                            @endif
                        @endcan
                        @can('approval', $transportationExpenses->first())
                            @if (empty($transportationExpenses->first()->approver))
                                <form
                                    action="{{ route('public.reports.transportation-expenses.approval', ['id' => $transportationExpenses->first()->employee_id, 'date' => $transportationExpenses->first()->applied_date->format('Y-m-d')]) }}"
                                    method="POST" onsubmit="return confirm('交通費申請を許可しますか？');">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">承認</button>
                                </form>
                            @endif
                        @endcan
                        @can('acceptance', $transportationExpenses->first())
                            @if (isset($transportationExpenses->first()->approver) && empty($transportationExpenses->first()->recipient))
                                <form
                                    action="{{ route('public.reports.transportation-expenses.acceptance', ['id' => $transportationExpenses->first()->employee_id, 'date' => $transportationExpenses->first()->applied_date->format('Y-m-d')]) }}"
                                    method="POST" onsubmit="return confirm('交通費申請を受理しますか？');">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">受理</button>
                                </form>
                            @endif
                        @endcan
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">利用日</th>
                                <th class="border px-4 py-2">始点 - 終点</th>
                                <th class="border px-4 py-2">金額</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transportationExpenses as $expense)
                                <tr>
                                    <td class="border px-4 py-2">{{ $expense->use_date->format('Y-m-d') }}</td>
                                    <td class="border px-4 py-2">{{ $expense->route_start }} -
                                        {{ $expense->route_end }}</td>
                                    <td class="border px-4 py-2">{{ number_format($expense->amount) }}円</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="2" class="border px-4 py-2">合計金額</p>
                                <td class="border px-4 py-2" colspan="3">
                                    {{ number_format($transportationExpenses->sum('amount')) }}円</p>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
