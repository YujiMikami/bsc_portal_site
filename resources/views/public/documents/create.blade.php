<?php

use function Psy\debug;
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            各種資料
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-xl font-semibold text-gray-800 mb-5">資料アップロード</h2>

                    <form action="{{ route('public.documents.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label>タイトル</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>ファイル（PDFまたはJPEG）</label>
                            <input type="file" name="file" class="form-control" accept=".pdf,.jpg,.jpeg" required>
                        </div>

                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">アップロード</button>
                        <a href="{{ route('public.documents.index') }}" class="inline-block bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">戻る</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>