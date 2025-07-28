<?php

use function Psy\debug;
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($occupations) ? '職種編集（ID: ' . $occupations->id . '）' : '職種登録' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6">
                        職種登録
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

                    <form action="{{ isset($occupation) ? route('admin.table.occupations.update', $occupation->occupation_id) : route('admin.table.occupations.store') }}"  method="POST">
                        @csrf
                            @if (isset($occupation))
                                @method('PUT')
                            @endif
                        <div class="mb-4">
                            <label for="occupation_id" class="block text-gray-700 text-sm font-bold mb-2">職種ID</label>
                            <input type="text" name="occupation_id" id="occupation_id" value="{{ old('occupation_id', $occupation->occupation_id ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline jQ-title">
                        </div>
                        
                        <div class="mb-4">
                            <label for="occupation_name" class="block text-gray-700 text-sm font-bold mb-2">職種名</label>
                            <input type="text" name="occupation_name" id="occupation_name" value="{{ old('occupation_name', $occupation->occupation_name ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline jQ-title">
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