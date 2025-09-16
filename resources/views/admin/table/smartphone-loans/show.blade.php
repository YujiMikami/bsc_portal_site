<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            貸与詳細（ 電話番号: {{ $smartphoneLoan->phone_number }} ）
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 text-gray-900">
                        <a href="{{ route('admin.table.smartphone-loans.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            戻る
                        </a>
                    </div>
                    <p class="mb-2">電話番号:{{ $smartphoneLoan->phone_number }}</p>
                    <p class="mb-2">貸与者社員番号:{{ $smartphoneLoan->employee_id }}</p>
                    <p class="mb-2">貸与者氏名:{{ $smartphoneLoan->employee_name }}</p>
                    <p class="mb-2">部署１:{{ config('departments.' . $smartphoneLoan->department_1) }}</p>
                    <p class="mb-2">部署２:{{ config('departments.' . $smartphoneLoan->department_2) }}</p>
                    <p class="mb-2">所属:{{ config('affiliations.' . $smartphoneLoan->affiliation) }}</p>
                    <p class="mb-2">メールアドレス:{{ $smartphoneLoan->email }}</p>
                    <p class="mb-2">貸与開始日:{{ $smartphoneLoan->loan_start_at }}</p>
                    <p class="mb-2">貸与終了日:{{ $smartphoneLoan->loan_end_at }}</p>
                    <p class="mb-2">機種:{{ $smartphoneLoan->model }}</p>
                    <p class="mb-2">あんしん保証パック:{{ config('const.guarantee.' . $smartphoneLoan->guarantee) }}</p>
                    <p class="mb-2">更新者:{{ $smartphoneLoan->update_by }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

