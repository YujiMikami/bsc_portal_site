<?php

use function Psy\debug;
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($employeeClass) ? '社員区分編集（ID: ' . $employeeClass->employee_class_id . '）' : '社員区分登録' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <a href="{{ route('admin.table.employee-classes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            戻る
                        </a>
                    </div>
                    <h1 class="text-2xl font-bold mb-6">
                        社員区分登録
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

                    <form action="{{ isset($employeeClass) ? route('admin.table.employee-classes.update', $employeeClass->employee_class_id) : route('admin.table.employee-classes.store') }}"  method="POST">
                        @csrf
                            @if (isset($employeeClass))
                                @method('PUT')
                            @endif
                        <div class="mb-4 flex">
                                <div class="mb-4 mr-3">
                                <label for="employee_class_id" class="block text-gray-700 text-sm font-bold mb-2">区分ID</label>
                                <input type="text" name="employee_class_id" id="employee_class_id" size="5" value="{{ old('employee_class_id', $employeeClass->employee_class_id ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline jQ-title">
                            </div>
                            
                            <div class="mb-4 mr-3">
                                <label for="employee_class_name" class="block text-gray-700 text-sm font-bold mb-2">区分名</label>
                                <input type="text" name="employee_class_name" id="employee_class_name" value="{{ old('employee_class_name', $employeeClass->employee_class_name ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline jQ-title">
                            </div>                        
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