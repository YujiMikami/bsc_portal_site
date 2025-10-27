<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            有給詳細
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 flex">
                        <div class="container">
                            <h2 class="text-xl font-semibold text-gray-800 mb-5">資料編集</h2>

                            <form action="{{ route('public.documents.update', $document->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label>タイトル</label>
                                    <input type="text" name="title" class="form-control"
                                        value="{{ old('title', $document->title) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label>現在のファイル</label><br>
                                    @if (in_array($document->file_type, ['jpg', 'jpeg']))
                                        <img src="{{ asset('storage/' . $document->file_path) }}"
                                            alt="{{ $document->title }}" width="200">
                                    @elseif ($document->file_type === 'pdf')
                                        <iframe src="{{ asset('storage/' . $document->file_path) }}" width="300"
                                            height="200"></iframe>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label>新しいファイル（変更する場合のみ）</label>
                                    <input type="file" name="file" class="form-control" accept=".pdf,.jpg,.jpeg">
                                </div>

                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">更新</button>
                                <a href="{{ route('public.documents.index') }}"
                                    class="inline-block bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">戻る</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
