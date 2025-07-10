<?php

use function Psy\debug;
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            安否登録
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6">
                        安否登録
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

                    <form action="{{ route('admin.safety.store') }}" method="POST">
                        @csrf
   
                        <div class="mb-6">
                            <label for="department" class="block text-gray-700 text-sm font-bold mb-2">部署：</label>
                            <select name="department" id="department">
                                <option value="{{ old('department', '') }}"></option>
                                <option value="ITビジネス事業部"{{ old('department', '') }}>ITビジネス事業部</option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <label for="on_site_name" class="block text-gray-700 text-sm font-bold mb-2">現場名：</label>
                            <select name="on_site_name" id="on_site_name">
                                <option value=></option>
                                <option value="本社">本社</option>
                            </select>   
                        </div>

                        <legend>ケガの有無</legend>
                        <div class="mb-6">
                            <label for="safety_status" class="block text-gray-700 text-sm font-bold mb-2">ケガ無し：
                                <input type="radio" name="safety_status" id="safety_status1" value="ケガ無し">
                            </label>
                            <label for="safety_status" class="block text-gray-700 text-sm font-bold mb-2">ケガ有り：
                                <input type="radio" name="safety_status" id="safety_status2" value="ケガ有り">
                            </label>
                        </div>

                        <div class="mb-4">
                            <label for="injury_status" class="block text-gray-700 text-sm font-bold mb-2">傷害度合：(擦り傷あり・切り傷有り・骨折箇所等)</label>
                            <input type="text" name="injury_status" id="injury_status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline jQ-title">
                        </div>

                        <legend>出社可否</legend>
                        <div class="mb-6">
                            <label for="can_work" class="block text-gray-700 text-sm font-bold mb-2">出社可　：
                                <input type="radio" name="can_work" id="can_work1" value="出社可">
                            </label>
                            <label for="can_work" class="block text-gray-700 text-sm font-bold mb-2">出社不可：
                                <input type="radio" name="can_work" id="can_work2" value="出社不可">
                            </label>
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