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
                    <div class="flex justify-start mb-4">
                        <a href="{{ route('admin.table.employees.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            社員登録
                        </a>
                        <form action="{{ route('admin.table.employees.configcsv') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" style="padding: 8px 15px;">CSVダウンロード</button>
                        </form>
                    </div>
                    <div class="p-6 text-gray-900">
                    <form method="GET" action="{{ route('admin.table.employees.index') }}">
                        <table>
                            <thead>
                                <th colspan="2">表示項目</th>
                                <th>検索値</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><label for="search_id">社員番号:</label></td>
                                    <td><input type="checkbox" name="search_id_check" value=true{{ !empty(request('search_id_check')) ? ' checked' : '' }}></td>
                                    <td><input type="text" id="search_id" name="search_id" value="{{ !empty(request('search_id')) ? request('search_id') : '' }}"></td>
                                </tr>
                                <tr>
                                    <td><label for="search_name">社員名:</label></td>
                                    <td><input type="checkbox" name="search_name_check" value=true{{ !empty(request('search_name_check')) ? ' checked' : '' }}></td>
                                    <td><input type="text" id="search_name" name="search_name" value="{{ !empty(request('search_name')) ? request('search_name') : '' }}"></td>
                                </tr>
                            </tbody>    
                        </table>    
                        <div>
                            <button type="submit" style="padding: 8px 15px;">検索</button>
                            <a href="{{ route('admin.table.employees.index') }}" role="button" style="padding: 8px 15px; text-decoration: none; border: 1px solid #ccc; color: #333;">リセット</a>
                        </div>
                    </form>

                </div>
                    
            
                    <div class="flex justify-start mb-4">
                    </div>
                    <table class="table-auto w-full border jQ-table">
                        <thead>
                            <tr>
                                @foreach ($employee->first()->getAttributes() as $column => $value)
                                    <th class="border px-4 py-2">{{ __('employee-columns.' . $column) }}</th>
                                @endforeach
                                <th class="border px-4 py-2">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($employee as $val)
                            <tr>
                                @if (isset($val->employee_id))
                                    <td class="border px-4 py-2">{{ $val->employee_id  }}</td>
                                @endif
                                @if (isset($val->employee_name))
                                    <td class="border px-4 py-2">{{ $val->employee_name }}</td>
                                @endif
                                @if (isset($val->department_id))
                                    <td class="border px-4 py-2">{{ $val->department_id }}</td>
                                @endif
                                @if (isset($val->affiliation_id))
                                    <td class="border px-4 py-2">{{ $val->affiliation_id }}</td>
                                @endif
                                <td class="border px-4 py-2">
                                    {{-- 詳細ボタンを追加 --}}
                                    <a href="{{ route('admin.table.employees.show', $val->employee_id) }}" class="text-blue-600 hover:underline">詳細</a>
                                    {{-- 編集ボタンを追加 --}}
                                    <a href="{{ route('admin.table.employees.edit', $val->employee_id) }}" class="ml-2 text-green-600 hover:underline">編集</a>
                                    {{-- 削除ボタンの追加 --}}
                                    <form action="{{ route('admin.table.employees.delete', $val->employee_id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline bg-transparent border-none cursor-pointer p-0 m-0">削除</button>
                                    </form>
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
                    "searching": false,
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