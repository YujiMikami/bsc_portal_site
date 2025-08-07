<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            変更履歴
        </h2>

    </x-slot>
    <!DOCTYPE html>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm rounded-lg">
                    <div class="p-6 text-gray-900">
                        <table class="table-auto border jQ-table">
                            <thead>
                                <tr>
                                    @if ($tableHistories->isEmpty())
                                        更新履歴がありません。
                                    @else
                                        <th class="border px-4 py-2">テーブル名</th>
                                        <th class="border px-4 py-2">ID</th>
                                        <th class="border px-4 py-2">名前</th>
                                        <th class="border px-4 py-2">行動</th>
                                        <th class="border px-4 py-2">項目名</th>
                                        <th class="border px-4 py-2">変更前</th>
                                        <th class="border px-4 py-2">変更後</th>
                                        <th class="border px-4 py-2">対応者</th>
                                        <th class="border px-4 py-2">対応日</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tableHistories as $val)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $val->table_name  }}</td>
                                        <td class="border px-4 py-2">{{ $val->target_id }}</td>
                                        <td class="border px-4 py-2">{{ $val->target_name }}</td>
                                        <td class="border px-4 py-2">{{ $val->action }}</td>
                                        <td class="border px-4 py-2">{{ isset($val->item_name) ? __('table-columns.' . $val->item_name) : ''}}</td>
                                        @switch ($val->item_name) 
                                            @case ('affiliation_id')
                                                <td class="border px-4 py-2">{{ config('affiliations.' . $val->before_update) }}</td>
                                                <td class="border px-4 py-2">{{ config('affiliations.' . $val->after_update) }}</td>
                                            @break
                                            @case ('department_id')
                                                <td class="border px-4 py-2">{{ config('departments.' . $val->before_update) }}</td>
                                                <td class="border px-4 py-2">{{ config('departments.' . $val->after_update) }}</td>
                                            @break
                                            @case ('employee_post_id')
                                                <td class="border px-4 py-2">{{ config('employee_posts.' . $val->before_update) }}</td>
                                                <td class="border px-4 py-2">{{ config('employee_posts.' . $val->after_update) }}</td>
                                            @break
                                            @case ('employee_class_id')
                                                <td class="border px-4 py-2">{{ config('employee_classes.' . $val->before_update) }}</td>
                                                <td class="border px-4 py-2">{{ config('employee_classes.' . $val->after_update) }}</td>
                                            @break
                                            @case ('occupation_id')
                                                <td class="border px-4 py-2">{{ config('occupations.' . $val->before_update) }}</td>
                                                <td class="border px-4 py-2">{{ config('occupations.' . $val->after_update) }}</td>
                                            @break
                                            @case ('gender')
                                                <td class="border px-4 py-2">{{ config('const.gender.' . $val->before_update) }}</td>
                                                <td class="border px-4 py-2">{{ config('const.gender.' . $val->after_update) }}</td>
                                            @break
                                            @case ('portal_role')
                                                <td class="border px-4 py-2">{{ config('const.portal_role.' . $val->before_update) }}</td>
                                                <td class="border px-4 py-2">{{ config('const.portal_role.' . $val->after_update) }}</td>
                                            @break
                                            @default
                                                <td class="border px-4 py-2">{{ $val->before_update }}</td>
                                                <td class="border px-4 py-2">{{ $val->after_update }}</td>
                                            @break
                                        @endswitch
                                        
                                        <td class="border px-4 py-2">{{ $val->responder }}</td>
                                        <td class="border px-4 py-2">{{ $val->compatible_date }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
                        { targets:[1, 2, 4, 5, 6, 7,], sortable: false },
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