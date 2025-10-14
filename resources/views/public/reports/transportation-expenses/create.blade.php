<?php

use function Psy\debug;
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            交通費申請
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6">
                        {{ empty($transportationExpenses) ? '交通費登録' : '交通費編集' }}
                    </h1>

                    {{-- バリデーションエラーメッセージの表示 --}}
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded relative" role="alert">
                            <strong class="font-bold">入力内容にエラーがあります！</strong>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ isset($transportationExpenses) && $transportationExpenses->isNotEmpty() ? route('public.reports.transportation-expenses.update', ['id' => $transportationExpenses->first()->employee_id, 'date' => $transportationExpenses->first()->applied_date]) : route('public.reports.transportation-expenses.store') }}" method="POST" onsubmit="return handleSubmit(event)">
                        @csrf
                        @if (isset($transportationExpenses))
                            @method('PUT')
                        @endif
                        <div class="mb-4 mr-3">
                            <label for="applied_date" class="block text-gray-700 text-sm font-bold mb-2">申請予定日：</label>
                            <input type="date" name="applied_date" id="applied_date" value="{{ old('applied_date', isset($transportationExpenses) ? \Carbon\Carbon::parse($transportationExpenses->first()->applied_date)->format('Y-m-d') : '') }}" class="shadow appearance-none border rounded  py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <label class="text-gray-700 text-sm font-bold ml-8 mr-10">利用日</label>
                        <label class="text-gray-700 text-sm font-bold ml-20 mr-20">始点</label>
                        <label class="text-gray-700 text-sm font-bold ml-24 mr-20">終点</label>
                        <label class="text-gray-700 text-sm font-bold ml-20 mr-20">金額</label>
                        <div id="expense-rows">
                            @forelse (collect(old('use_date', $transportationExpenses ?? []))->values() as $i => $expense )
                                <div class="expense-row flex mb-4 items-center">
                                    <span class="row-number mr-2 w-5 ">{{ $i + 1 }}</span>
                                    <input type="hidden" name="expense_id[]" value="{{ $expense->id ?? '' }}">    
                                    <input type="date" name="use_date[]" value="{{ old('use_date.' . $i, isset($expense['use_date']) ? $expense['use_date']->format('Y-m-d') : '') }}" class="mr-2 w-40">
                                    <input type="text" name="route_start[]" value="{{ old('route_start.' . $i, $expense['route_start'] ?? '') }}" class="mr-2">
                                    <input type="text" name="route_end[]" value="{{ old('route_end.' . $i, $expense['route_end'] ?? '') }}" class="mr-2">
                                    <input type="text" name="amount[]" value="{{ old('amount.' . $i, $expense['amount'] ?? '') }}" class="mr-2">
                                    <button type="button" class="remove-row bg-red-500 hover:bg-red-700 text-white px-2 rounded">削除</button>
                                </div>
                            @empty
                                @foreach (range(0, max(count($expenses ?? []), 1) - 1) as $i)
                                    <div class="expense-row flex mb-4 items-center">
                                        <span class="row-number mr-2 w-5">{{ $i + 1 }}</span>
                                        <input type="hidden" name="expense_id[]" value="">    
                                        <input type="date" name="use_date[]" value="{{ old('use_date.' . $i) }}" class="mr-2 w-40">
                                        <input type="text" name="route_start[]" value="{{ old('route_start.' . $i) }}" class="mr-2">
                                        <input type="text" name="route_end[]" value="{{ old('route_end.' . $i) }}" class="mr-2">
                                        <input type="text" name="amount[]" value="{{ old('amount.' . $i) }}" class="mr-2">
                                        <button type="button" class="remove-row bg-red-500 hover:bg-red-700 text-white px-2 rounded">削除</button>
                                    </div>
                                @endforeach
                            @endforelse
                        </div>
                        {{-- 新規行追加 --}}
                        <button type="button" id="add-row" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded mb-4">+ 行を追加</button>
                        <div class="flex items-center justify-end">
                            <a href="{{ route('public.reports.transportation-expenses.index') }}" class="mr-3 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                戻る
                            </a>
                            <input type="submit" name="action" value="保存" class="mr-3 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            <input type="submit" name="action" value="申請" class="mr-3 bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        // 行追加・削除の処理
        const rowsContainer = document.getElementById('expense-rows');
        const addBtn = document.getElementById('add-row');

        function updateRowNumbers() {
            rowsContainer.querySelectorAll('.expense-row').forEach((row, index) => {
                row.querySelector('.row-number').textContent = index + 1;
            });
        }

        addBtn.addEventListener('click', () => {
            const lastRow = rowsContainer.querySelector('.expense-row:last-child');
            const newRow = lastRow.cloneNode(true);

            // input をリセット
            newRow.querySelectorAll('input').forEach(input => input.value = '');

            rowsContainer.appendChild(newRow);
            updateRowNumbers();

            // 削除ボタンイベント設定
            newRow.querySelector('.remove-row').addEventListener('click', () => removeRow(newRow));
        });

        // 既存削除ボタンにもイベントを設定
        rowsContainer.querySelectorAll('.remove-row').forEach(btn => {
            const row = btn.closest('.expense-row');
            btn.addEventListener('click', () => removeRow(row));
        });

        function removeRow(row) {
            // 最低1行は残す
            if (rowsContainer.querySelectorAll('.expense-row').length > 1) {
                row.remove();
                updateRowNumbers();
            } else {
                alert('行は1つ以上必要です。');
            }
        }

        function handleSubmit(event) {
            const submitter = event.submitter; // 押されたボタン

            if (submitter && submitter.value === "申請") {
                if (!confirm("申請してもよろしいですか？")) {
                    event.preventDefault(); // キャンセルなら送信中止
                    return false;
                }
            }

            // ★ disabled の代わりに見た目＋操作無効化
            submitter.setAttribute("data-disabled", "true");
            submitter.style.pointerEvents = "none"; // クリックできなくする
            submitter.style.opacity = "0.5";        // 無効っぽく見せる

            return true;
        }

    </script>
</x-app-layout>