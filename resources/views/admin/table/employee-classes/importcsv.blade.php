<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            CSVインポート
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg">
                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded relative" role="alert">
                    {{ session('success') }}
                    </div>
                @endif
                <div class="p-6 text-gray-900">
                    <h1>インポートするファイルを選択してください。</h1>
                    <form action="{{ route('admin.table.employee-classes.uploadcsv') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label for="csv_file">CSVファイルを選択</label>
                        <input type="file" name="csv_file" required>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">インポート</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

