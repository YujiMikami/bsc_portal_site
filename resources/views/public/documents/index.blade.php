<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            各種資料
        </h2>
    </x-slot>
    
    <!DOCTYPE html>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm rounded-lg">
                    <div class="p-6 text-gray-900">
                        @if (session('success'))
                            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded relative" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="flex justify-start mb-4">
                            <div class="container">
                                <h2 class="text-xl font-semibold text-gray-800 mb-5">公開資料一覧</h2>
                                @can('access-admin-panel')
                                    <a href="{{ route('public.documents.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">新規アップロード</a>
                                @endcan
                                @if ($documents->isempty())
                                    <p class="mt-5">資料はありません。</p>    
                                @else
                                    @foreach ($documents as $document)
                                    <div class="card mb-3 p-3">
                                        <h5 class="text-xl font-semibold text-gray-800">{{ $document->title }}</h5>
                                            @if (in_array($document->file_type, ['jpg', 'jpeg']))
                                                <img src="{{ asset('storage/'.$document->file_path) }}" alt="{{ $document->title }}" class="img-fluid">
                                            @elseif ($document->file_type === 'pdf')
                                                <iframe src="{{ route('public.documents.view', $document->id) }}#view=FitH&toolbar=0" width="100%" height="400px"></iframe>
                                            @endif

                                            <div class="mt-3 flex gap-2">
                                                <a href="{{ asset('storage/'.$document->file_path) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mb-5" download>ダウンロード</a>
                                                @can('access-admin-panel')
                                                    <a href="{{ route('public.documents.edit', $document) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mb-5">編集</a>
                                                    <form action="{{ route('public.documents.delete', $document) }}" method="POST" onsubmit="return confirm('削除しますか？')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mb-5">削除</button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>