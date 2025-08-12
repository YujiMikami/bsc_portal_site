<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            プロフィール
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1>下記データが保存されています。<br>
                        相違がある場合は総務部までご連絡ください。
                    </h1>
                    <table class="table-auto border jQ-table">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">項目</th>
                                <th class="border px-4 py-2">登録データ</th>
                            </tr>    
                        </thead>    
                        <tbody>
                            <tr>
                                <td class="border px-4 py-2">社員番号</td>
                                <td class="border px-4 py-2">{{ $profile->employee_id }}</td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2">社員名（漢字）</td>
                                <td class="border px-4 py-2">{{ $profile->employee_name }}</td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2">社員名（ふりがな）</td>
                                <td class="border px-4 py-2">{{ $profile->employee_name_furigana }}</td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2">社員区分</td>
                                <td class="border px-4 py-2">{{ $profile->employeeClass->employee_class_name ?? '未設定' }}</td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2">部署</td>
                                <td class="border px-4 py-2">{{ $profile->department->department_name ?? '未設定' }}</td>
                            </tr>                        
                            <tr>
                                <td class="border px-4 py-2">所属</td>
                                <td class="border px-4 py-2">{{ $profile->affiliation->affiliation_name ?? '未設定' }}</td>
                            </tr>                        
                            <!-- <tr>役職は社員テーブルにないため除外
                                <td class="border px-4 py-2">役職</td>
                                <td class="border px-4 py-2">{{ $profile->employeePost->employee_post_name ?? '未設定' }}</td>
                            </tr> -->
                            <tr>
                                <td class="border px-4 py-2">職種</td>
                                <td class="border px-4 py-2">{{ $profile->occupation->occupation_name ?? '未設定' }}</td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2">メールアドレス</td>
                                <td class="border px-4 py-2">{{ Auth::User()->email }}</td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2">ポータル権限</td>
                                <td class="border px-4 py-2">{{ config('const.portal_role.' . Auth::User()->portal_role) }}</td>
                            </tr>







                        </tbody>
                        

                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

