<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            社員テーブル
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
                    @if (session('error'))
                        <div class="mb-4 p-4 bg-red-100 border border-green-400 text-green-700 rounded relative" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                        <div class="flex justify-start mb-4">
                        <a href="{{ route('admin.table.employees.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mx-2 rounded focus:outline-none focus:shadow-outline">
                            社員登録
                        </a>
                        <a href="{{ route('admin.table.employees.exportcsv') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 mx-2 rounded focus:outline-none focus:shadow-outline">
                            CSVエクスポート
                        </a>
                        <a href="{{ route('admin.table.employees.importcsv') }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 mx-2 rounded focus:outline-none focus:shadow-outline">
                            CSVインポート
                        </a>
                    </div>
                    <form method="GET" action="{{ route('admin.table.employees.index') }}" class="mb-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="in_retired_persons" value="1" class="form-checkbox"{{ request()->has('in_retired_persons') ? 'checked' : '' }}>
                            <span class="ml-2">退職者も表示</span>
                        </label>
                        <button type="submit" class="ml-4 bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                            表示切替
                        </button>
                    </form>
                    @if ($inRetiredPersons)
                        <p class="text-red-800">名前が赤い社員は退職者です</p> 
                    @endif                   
                    <table class="table-auto border jQ-table">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">社員番号</th>
                                <th class="border px-4 py-2">社員名</th>
                                <th class="border px-4 py-2">部署</th>
                                <th class="border px-4 py-2">所属</th>
                                <th class="border px-4 py-2">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $val)
                                <tr>
                                    <td class="border px-4 py-2">{{ $val->employee_id  }}</td>
                                    <td class="border px-4 py-2 {{ $val->retirement_date ? 'bg-red-200 text-red-800' : '' }}">{{ $val->employee_name }}</td>
                                    <td class="border px-4 py-2">{{ $val->department->department_name ?? '未設定' }}</td>
                                    <td class="border px-4 py-2">{{ $val->affiliation->affiliation_name  ?? '未設定' }}</td>
                                    <td class="border px-4 py-2">
                                        <div class="flex items-center space-x-4">
                                            {{-- 詳細ボタンを追加 --}}
                                            <a href="{{ route('admin.table.employees.show', $val->employee_id) }}" class="text-blue-600 hover:underline">詳細</a>
                                            {{-- 編集ボタンを追加 --}}
                                            <a href="{{ route('admin.table.employees.edit', $val->employee_id) }}" class="ml-2 text-green-600 hover:underline">編集</a>
                                            {{-- 削除ボタンの追加 --}}
                                            <form action="{{ route('admin.table.employees.delete', $val->employee_id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？（データベースからも削除されます）');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline bg-transparent border-none cursor-pointer p-0 m-0">削除</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('script')
        {{--tableにソート機能等を追加--}}
        <script>
            //テーブルのカラム数を取得
            var columnCount = $('.jQ-table thead tr th').length;
            console.log('カラム数:', columnCount);
            $(document).ready(function() {
                var tableOptions = {
                    //テーブル情報の表示
                    "info": true,
                    //インデックスを指定して設定する
                    "columnDefs": [
                        { targets:columnCount - 1, sortable: false },
                    ],
                    //検索機能を追加する
                    "searching": true,
                    //ページ機能を追加する
                    "paging": true,
                    //日本語化する
                    "language": {
                        "url": "{{ asset('js/datatables/ja.json') }}"
                    }
                }
                $('.jQ-table').DataTable(tableOptions);
                $('.jQ-table').on('draw.dt', function() {
                    $('#dt-length-0').css('width', '70px');
                    $('#DataTables_Table_0_wrapper').css('padding', '10px');
                });
            });
        </script>  
    @endpush
</x-app-layout>