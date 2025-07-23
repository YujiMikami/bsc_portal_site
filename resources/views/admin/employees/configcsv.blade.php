<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            CSVダウンロード
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1>出力したい項目を選択してください。</h1>
                    <form method="GET" action="{{ route('admin.employees.downloadcsv') }}">
                        <div style="margin:10px;">
                            <label for="search_id">社員番号:</label>
                            <input type="checkbox" name="search_id_check" value=true{{ !empty(request('search_id_check')) ? ' checked' : '' }}>
                        </div>
                        <div style="margin:10px;">
                            <label for="search_name">社員名:</label>
                            <input type="checkbox" name="search_name_check" value=true{{ !empty(request('search_name_check')) ? ' checked' : '' }}>
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" style="padding: 8px 15px;">ダウンロード</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

