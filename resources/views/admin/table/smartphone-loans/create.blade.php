<?php

use function Psy\debug;
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($smartphoneLoan) ? '貸与編集（電話番号: ' . $smartphoneLoan->phone_number . '）' : '貸与登録' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <a href="{{ route('admin.table.smartphone-loans.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            戻る
                        </a>
                    </div>
                    <h1 class="text-2xl font-bold mb-6">
                        貸与登録
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

                    <form onsubmit="disableButton()" action="{{ isset($smartphoneLoan) ? route('admin.table.smartphone-loans.update', $smartphoneLoan->id) : route('admin.table.smartphone-loans.store') }}"  method="POST">
                        @csrf
                            @if (isset($smartphoneLoan))
                                @method('PUT')
                            @endif
                        <div class="mb-4 mr-3">
                            <div class="mb-4 mr-3">
                                <label for="phone_number" class="block text-gray-700 text-sm font-bold mb-2">電話番号</label>
                                <input type="text" name="phone_number" id="phone_number" size="15" value="{{ old('phone_number', $smartphoneLoan->phone_number ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            
                            <div class="mr-3 flex">
                                <div class="mb-4 mr-3">
                                    <label for="employee_id" class="block text-gray-700 text-sm font-bold mb-2">貸与者社員番号</label>
                                    <input type="text" name="employee_id" id="employee_id" size="6" value="{{ old('employee_id', $smartphoneLoan->employee_id ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>                            
                                <div class="mb-4 mr-3">
                                    <label for="employee_name" class="block text-gray-700 text-sm font-bold mb-2">貸与者氏名</label>
                                    <input type="text" name="employee_name" id="employee_name" size="40" value="{{ old('employee_name', $smartphoneLoan->employee_name ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>                             
                            </div>
                            
                            <div class="mr-3 flex">
                                <div class="mb-4 mr-3">
                                    <label for="department_1" class="block text-gray-700 text-sm font-bold mb-2">部署1：</label>
                                    <select name="department_1" id="department_1" class="rounded leading-tight">
                                        <option value=""></option>
                                        @foreach (config('departments') as $key=>$val)
                                            <option value="{{ $key }}"
                                                {{ old('department_1', $smartphoneLoan->department_1 ?? '') == $key ? 'selected' : '' }}>
                                                {{ $val }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="mb-4 mr-3">
                                    <label for="department_2" class="block text-gray-700 text-sm font-bold mb-2">部署2：</label>
                                    <select name="department_2" id="department_2" class="rounded leading-tight">
                                        <option value=""></option>
                                        @foreach (config('departments') as $key=>$val)
                                            <option value="{{ $key }}"
                                                {{ old('department_2', $smartphoneLoan->department_2 ?? '') == $key ? 'selected' : '' }}>
                                                {{ $val }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-4 mr-3">
                                    <label for="affiliation" class="block text-gray-700 text-sm font-bold mb-2">所属：</label>
                                    <select name="affiliation" id="affiliation" class="rounded leading-tight">
                                        <option value=""></option>
                                        @foreach (config('affiliations') as $key=>$val)
                                            <option value="{{ $key }}"
                                                {{ old('affiliation', $smartphoneLoan->affiliation ?? '') == $key ? 'selected' : '' }}>
                                                {{ $val }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4 mr-3">
                                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">メールアドレス</label>
                                <input type="text" name="email" id="email" size="40" value="{{ old('email', $smartphoneLoan->email ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>  

                            <div class="mr-3 flex">
                                <div class="mb-4 mr-3">
                                    <label for="loan_start_at" class="block text-gray-700 text-sm font-bold mb-2">貸与開始日：</label>
                                    <input type="date" name="loan_start_at" id="loan_start_at" value="{{ old('loan_start_at', isset($smartphoneLoan->loan_start_at) ? \Carbon\Carbon::parse($smartphoneLoan->loan_start_at)->format('Y-m-d') : '') }}" class="shadow appearance-none border rounded  py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>

                                <div class="mb-4 mr-3">
                                    <label for="loan_end_at" class="block text-gray-700 text-sm font-bold mb-2">貸与終了日：</label>
                                    <input type="date" name="loan_end_at" id="loan_end_at" value="{{ old('loan_end_at', isset($smartphoneLoan->loan_end_at) ? \Carbon\Carbon::parse($smartphoneLoan->loan_end_at)->format('Y-m-d') : '') }}" class="shadow appearance-none border rounded  py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                            </div>

                            <div class="mr-3 flex">
                                <div class="mb-4 mr-3">
                                    <label for="model" class="block text-gray-700 text-sm font-bold mb-2">機種</label>
                                    <input type="text" name="model" id="model" size="40" value="{{ old('model', $smartphoneLoan->model ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>  

                                <div class="mb-4 mr-3">
                                    <label for="guarantee" class="block text-gray-700 text-sm font-bold mb-2">あんしん保証パック：</label>
                                    <select name="guarantee" id="guarantee" class="rounded leading-tight">
                                        @foreach (config('const.guarantee') as $key=>$val)
                                            <option value=$key {{ old('guarantee', $smartphoneLoan->guarantee ?? '') == $key ? 'selected' : '' }}>{{ $val }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end">
                            <button id="submit-btn" type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                登録
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>