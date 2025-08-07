<?php

use function Psy\debug;
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            有給申請
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6">
                        有給登録
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

                    <form action="{{ isset($paidRequest) ? route('public.reports.paid-requests.update', $paidRequest->id) : route('public.reports.paid-requests.store') }}"  method="POST">
                        @csrf
                            @if (isset($paidRequest))
                                @method('PUT')
                            @endif
                        <div class="mb-4 flex">
                            <div class="mb-4 mr-3">
                                <label for="application_date" class="block text-gray-700 text-sm font-bold mb-2">申請日：</label>
                                <input type="date" name="application_date" id="application_date" value="{{ old('application_date', isset($paidRequest->application_date) ? \Carbon\Carbon::parse($paidRequest->application_date)->format('Y-m-d') : \Carbon\Carbon::parse(now())->format('Y-m-d')) }}" class="shadow appearance-none border rounded  py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            

                            <div class="mb-4 mr-3">
                                <label for="employee_id" class="block text-gray-700 text-sm font-bold mb-2 ">社員番号</label>
                                <input type="text" name="employee_id" id="employee_id" size="6" value="{{ Auth::user()->employee_id }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly>
                            </div>
                        </div>
                        
                        <div class="mb-4 flex">
                            <div class="mb-4 mr-3">
                                <label for="affiliation" class="block text-gray-700 text-sm font-bold mb-2 ">所属</label>
                                <input type="text" name="affiliation" id="affiliation" value="{{ config('affiliations.' .Auth::user()->affiliation_id) }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly>
                            </div>
                            <div class="mb-4 mr-3">
                                <label for="employee_name" class="block text-gray-700 text-sm font-bold mb-2 ">社員名</label>
                                <input type="text" name="employee_name" id="employee_name" size="20" value="{{ Auth::user()->employee_name }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly>
                            </div>                        
                        </div>

                        <div class="mb-4 flex">
                            <div class="mb-4 mr-3">
                                <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">開始日：</label>
                                <input type="date" name="start_date" id="start_date" value="{{ old('start_date', isset($paidRequest->start_date) ? \Carbon\Carbon::parse($paidRequest->start_date)->format('Y-m-d') : '') }}" class="shadow appearance-none border rounded  py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="mb-4 mr-3">
                                <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">終了日：</label>
                                <input type="date" name="end_date" id="end_date" value="{{ old('end_date', isset($paidRequest->end_date) ? \Carbon\Carbon::parse($paidRequest->end_date)->format('Y-m-d') : '') }}" class="shadow appearance-none border rounded  py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="mb-4 mr-3">
                                <label for="days" class="block text-gray-700 text-sm font-bold mb-2 ">日数</label>
                                <input type="text" name="days" id="days" size="2" value="{{ old('days', $paidRequest->days ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">日間
                            </div>
                        </div>
                        <div class="mb-6">
                            <label for="distinction" class="block text-gray-700 text-sm font-bold mb-2">区分</label>
                            <select name="distinction" id="distinction" class="rounded leading-tight">
                                @foreach (config('const.paid_distinction') as $val)
                                    <option value="{{ $val }}"{{ old('distinction', $paidRequest->distinction ?? '') == $val ? 'selected ' : '' }}>
                                        {{ $val }}
                                    </option>
                                @endforeach
                            </select>   
                        </div>

                        <div class="mb-4">
                            <label for="reason" class="block text-gray-700 text-sm font-bold mb-2 ">理由</label>
                            <input type="text" name="reason" id="reason" size="30" value="{{ old('reason', $paidRequest->reason ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label for="note" class="block text-gray-700 text-sm font-bold mb-2 ">備考</label>
                            <input type="text" name="note" id="note" size="30" value="{{ old('note', $paidRequest->note ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('public.reports.paid-requests.index') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                戻る
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                登録
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>