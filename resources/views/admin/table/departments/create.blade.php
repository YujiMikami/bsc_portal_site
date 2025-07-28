<?php

use function Psy\debug;
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($departments) ? '部署編集（ID: ' . $departments->id . '）' : '部署登録' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6">
                        部署登録
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

                    <form action="{{ isset($department) ? route('admin.table.departments.update', $department->department_id) : route('admin.table.departments.store') }}"  method="POST">
                        @csrf
                            @if (isset($department))
                                @method('PUT')
                            @endif
                        <div class="mb-4">
                            <label for="department_id" class="block text-gray-700 text-sm font-bold mb-2">部署ID</label>
                            <input type="text" name="department_id" id="department_id" value="{{ old('department_id', $department->department_id ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline jQ-title">
                        </div>
                        
                        <div class="mb-4">
                            <label for="department_name" class="block text-gray-700 text-sm font-bold mb-2">部署名</label>
                            <input type="text" name="department_name" id="department_name" value="{{ old('department_name', $department->department_name ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline jQ-title">
                        </div>                        
                        
                        <div class="mb-4">
                            <label for="department_explanation" class="block text-gray-700 text-sm font-bold mb-2">説明</label>
                            <input type="text" name="department_explanation" id="department_explanation" value="{{ old('department_explanation', $department->department_explanation ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline jQ-title">
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