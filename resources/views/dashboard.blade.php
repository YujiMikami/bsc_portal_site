<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ダッシュボード') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    ここに各通知やお知らせを載せます。<br><br>
                
                    更新内容：<br>
                    社員名簿<br>
                    登録・更新・詳細・削除機能を追加<br>
                    カラムの指定<br>
                    社員名簿のCSV出力<br>
                    <br>
                    実装予定：<br>
                    シフト表<br>
                    チャット機能<br>
                    有給申請<br>
                    交通費申請<br>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
