<?php

use function Psy\debug;
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($notification) ? 'お知らせ編集' : 'お知らせ登録' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

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

                    <form action="{{ isset($notification) ? route('admin.notification.update', $notification->id) : route('admin.notification.store') }}"  method="POST">
                        @csrf
                            @if (isset($notification))
                                @method('PUT')
                            @endif
                        <div class="mb-6">
                            <a href="{{ route('admin.notification.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                戻る
                            </a>
                        </div>   
                        <label for="employee_id" class="block text-red-700 text-sm font-bold mb-2 ">赤字タイトルは必須項目です</label>
                        
                        <div class="mb-4">
                            <div class="mb-4 mr-3">
                                <label for="title" class="block text-red-700 text-sm font-bold mb-2">タイトル</label>
                                <input type="text" name="title" id="title" size="100" value="{{ old('title', $notification->title ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>                        
                            
                            <div class="mb-4 mr-3">
                                <label for="body" class="block text-red-700 text-sm font-bold mb-2">内容</label>
                                <textarea name="body" id="body" rows="10" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-full h-60">{{ old('body', $notification->body ?? '') }}</textarea>
                            </div>

                            <div class="mb-4 mr-3">
                                <label for="start_at" class="block text-gray-700 text-sm font-bold mb-2">公開日：指定無しの場合、即時公開されます</label>
                                <input type="datetime-local" name="start_at" id="start_at" value="{{ old('start_at', isset($notification->start_at) ? $notification->start_at->format('Y-m-d\TH:i') : '') }}" class="shadow appearance-none border rounded  py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="mb-4 mr-3">
                                <label for="end_at" class="block text-gray-700 text-sm font-bold mb-2">終了日：指定無しの場合、永続的に公開されます</label>
                                <input type="datetime-local" name="end_at" id="end_at" value="{{ old('end_at', isset($notification->end_at) ? $notification->end_at->format('Y-m-d\TH:i') : '') }}" class="shadow appearance-none border rounded  py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
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