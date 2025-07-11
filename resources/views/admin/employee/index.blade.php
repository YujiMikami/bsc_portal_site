<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            社員名簿
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
                    </div>
                    <table class="table-auto w-full border jQ-table">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">社員番号</th>
                                <th class="border px-4 py-2">社員名</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($employee as $val)
                            <tr>
                                <td class="border px-4 py-2">{{ $val->employee_id  }}</td>
                                <td class="border px-4 py-2">{{ $val->employee_name }}</td>
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
            $(document).ready(function() {
                var tableOptions = {
                    //テーブル情報の表示
                    "info": true,
                    //インデックスを指定して設定する
                    "columnDefs": [],
                    //検索機能を追加する
                    "searching": true,
                    //ページ機能を追加する
                    "paging": true,
                    //日本語化する
                    "language": {
                        "url": "https:cdn.datatables.net/plug-ins/1.10.16/i18n/Japanese.json"
                    
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