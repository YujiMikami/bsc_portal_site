<?php

use function Psy\debug;
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($employee) ? '社員編集（ID: ' . $employee->id . '）' : '社員登録' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6">
                        社員登録
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

                    <form action="{{ isset($employee) ? route('admin.employee.update', $employee->employee_id) : route('admin.employee.store') }}"  method="POST">
                        @csrf
                            @if (isset($employee))
                                @method('PUT')
                            @endif
                        <div class="mb-4">
                            <label for="employee_id" class="block text-gray-700 text-sm font-bold mb-2">社員番号</label>
                            <input type="text" name="employee_id" id="employee_id" value="{{ old('employee_id', $employee->employee_id ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline jQ-title">
                        </div>
                        
                        <div class="mb-4">
                            <label for="employee_name" class="block text-gray-700 text-sm font-bold mb-2">社員名</label>
                            <input type="text" name="employee_name" id="employee_name" value="{{ old('employee_name', $employee->employee_name ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline jQ-title">
                        </div>                        
                        
                        <div class="mb-6">
                            <label for="department" class="block text-gray-700 text-sm font-bold mb-2">部署：</label>
                            <select name="department" id="department">
                                @foreach (config('const.department') as $key => $val)
                                    <option value="{{ $key }}"{{ old('department', $employee->department ?? '') == $key ? ' selected' : '' }}>{{ $val }}</option>
                                @endforeach    
                            </select>
                        </div>

                        <div class="mb-6">
                            <label for="post" class="block text-gray-700 text-sm font-bold mb-2">役職：</label>
                            <select name="post" id="post">
                                @foreach (config('const.post') as $key => $val)
                                    <option value="{{ $key }}"{{ old('post', $employee->post ?? '') == $key ? ' selected' : '' }}>{{ $val }}</option>
                                @endforeach  
                            </select>
                        </div>

                        <div class="mb-6">
                            <label for="portal_role" class="block text-gray-700 text-sm font-bold mb-2">ポータル権限：</label>
                            <select name="portal_role" id="portal_role">
                                @foreach (config('const.portal_role') as $key => $val)
                                    <option value="{{ $key }}"{{ old('portal_role', $employee->portal_role ?? '') == $key ? ' selected' : '' }}>{{ $val }}</option>
                                @endforeach   
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="address" class="block text-gray-700 text-sm font-bold mb-2">住所</label>
                            <input type="text" name="address" id="address" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline jQ-title">
                        </div> 

                        <div class="mb-6">
                            <label for="hire_date" class="block text-gray-700 text-sm font-bold mb-2">雇用日：</label>
                            {{-- DateTimeオブジェクトをdatetime-local形式にフォーマット --}}
                            <input type="datetime-local" name="hire_date" id="hire_date" value="{{ old('hire_date', isset($task->hire_date) ? \Carbon\Carbon::parse($task->hire_date)->format('Y-m-d\TH:i') : '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-6">
                            <label for="retirement_date" class="block text-gray-700 text-sm font-bold mb-2">退職日：</label>
                            {{-- DateTimeオブジェクトをdatetime-local形式にフォーマット --}}
                            <input type="datetime-local" name="retirement_date" id="retirement_date" value="{{ old('retirement_date', isset($task->retirement_date) ? \Carbon\Carbon::parse($task->retirement_date)->format('Y-m-d\TH:i') : '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        
                        <div class="flex items-center justify-end">
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