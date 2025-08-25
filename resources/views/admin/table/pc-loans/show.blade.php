<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            貸与詳細（ ＰＣナンバー: {{ $pcLoan->pc_number }} ）
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 text-gray-900">
                        <a href="{{ route('admin.table.pc-loans.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            戻る
                        </a>
                    </div>
                    <p class="mb-2">ＰＣナンバー:{{ $pcLoan->pc_number }}</p>
                    <p class="mb-2">ＳｅｒｖｉｃｅＴａｇ(S/N):{{ $pcLoan->service_tag }}</p>
                    <p class="mb-2">ＯＳ:{{ $pcLoan->os }}</p>
                    <p class="mb-2">ＰＣ名:{{ $pcLoan->pc_name }}</p>
                    <p class="mb-2">ＰＩＮ:{{ $pcLoan->pin }}</p>
                    <p class="mb-2">ｏｆｆｉｃｅ:{{ $pcLoan->office }}</p>
                    <p class="mb-2">ｏｆｆｉｃｅライセンス:{{ $pcLoan->office_lisence }}</p>
                    <p class="mb-2">セキュリティソフト:{{ $pcLoan->security_soft }}</p>
                    <p class="mb-2">ＢＩＯＳパス:{{ $pcLoan->bios_pass }}</p>
                    <p class="mb-2">Ｆｏｔｉｃｌｉｅｎｔアカウント:{{ $pcLoan->foticlient_account }}</p>
                    <p class="mb-2">Ｆｏｔｉｃｌｉｅｎｔパス:{{ $pcLoan->foticlient_pass }}</p>
                    <p class="mb-2">使用者ID:{{ $pcLoan->employee_id }}</p>
                    <p class="mb-2">使用者:{{ $pcLoan->employee_name }}</p>
                    <p class="mb-2">ｗｉ－ｆｉ:{{ $pcLoan->wifi }}</p>
                    <p class="mb-2">ＭＳアカウント:{{ $pcLoan->ms_account }}</p>
                    <p class="mb-2">ＭＳパス:{{ $pcLoan->ms_pass }}</p>
                    <p class="mb-2">更新者:{{ $pcLoan->update_by }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

