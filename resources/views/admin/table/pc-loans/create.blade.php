<?php

use function Psy\debug;
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($pcLoan) ? '貸与編集（ＰＣナンバー: ' . $pcLoan->pc_number . '）' : '貸与登録' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <a href="{{ route('admin.table.pc-loans.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            戻る
                        </a>
                    </div>
                    <h1 class="text-2xl font-bold mb-6">
                        貸与登録
                    </h1>

                    {{-- バリデーションエラーメッセージの表示 --}}
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded relative" role="alert">
                            <strong class="font-bold">入力内容にエラーがあります！</strong>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form onsubmit="disableButton()" action="{{ isset($pcLoan) ? route('admin.table.pc-loans.update', $pcLoan->id) : route('admin.table.pc-loans.store') }}"  method="POST">
                        @csrf
                            @if (isset($pcLoan))
                                @method('PUT')
                            @endif
                        <div class="mb-4">
                            <div class="mr-3 flex">
                                <div class="mb-4 mr-3">
                                    <label for="pc_number" class="block text-gray-700 text-sm font-bold mb-2">ＰＣナンバー</label>
                                    <input type="text" name="pc_number" id="pc_number" size="20" value="{{ old('pc_number', $pcLoan->pc_number ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline jQ-title">
                                </div>

                                <div class="mb-4 mr-3">
                                    <label for="pc_name" class="block text-gray-700 text-sm font-bold mb-2">ＰＣ名</label>
                                    <input type="text" name="pc_name" id="pc_name" size="40" value="{{ old('pc_name', $pcLoan->pc_name ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline jQ-title">
                                </div>
                            </div>

                            <div class="mr-3 flex">
                                <div class="mb-4 mr-3">
                                    <label for="service_tag" class="block text-gray-700 text-sm font-bold mb-2">ＳｅｒｖｉｃｅＴａｇ(S/N)</label>
                                    <input type="text" name="service_tag" id="service_tag" size="20" value="{{ old('service_tag', $pcLoan->service_tag ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline jQ-title">
                                </div>
                                                            
                                <div class="mb-4 mr-3">
                                    <label for="os" class="block text-gray-700 text-sm font-bold mb-2">ＯＳ</label>
                                    <input type="text" name="os" id="os" size="40" value="{{ old('os', $pcLoan->os ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline jQ-title">
                                </div>
                            </div>
                                                        
                            <div class="mb-4 mr-3">
                                <label for="pin" class="block text-gray-700 text-sm font-bold mb-2">ＰＩＮ</label>
                                <input type="text" name="pin" id="pin" size="20" value="{{ old('pin', $pcLoan->pin ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline jQ-title">
                            </div>

                            <div class="mr-3 flex">
                                <div class="mb-4 mr-3">
                                    <label for="office" class="block text-gray-700 text-sm font-bold mb-2">ｏｆｆｉｃｅ</label>
                                    <input type="text" name="office" id="office" size="30" value="{{ old('office', $pcLoan->office ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline jQ-title">
                                </div>
                                                            
                                <div class="mb-4 mr-3">
                                    <label for="office_lisence" class="block text-gray-700 text-sm font-bold mb-2">ｏｆｆｉｃｅライセンス</label>
                                    <input type="text" name="office_lisence" id="office_lisence" size="30" value="{{ old('office_lisence', $pcLoan->office_lisence ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline jQ-title">
                                </div>
                            </div>
                            
                            <div class="mr-3 flex">
                                <div class="mb-4 mr-3">
                                    <label for="security_soft" class="block text-gray-700 text-sm font-bold mb-2">セキュリティソフト</label>
                                    <input type="text" name="security_soft" id="security_soft" size="20" value="{{ old('security_soft', $pcLoan->security_soft ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline jQ-title">
                                </div>
                                                            
                                <div class="mb-4 mr-3">
                                    <label for="bios_pass" class="block text-gray-700 text-sm font-bold mb-2">ＢＩＯＳパス</label>
                                    <input type="text" name="bios_pass" id="bios_pass" size="20" value="{{ old('bios_pass', $pcLoan->bios_pass ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline jQ-title">
                                </div>
                            </div>
                            <div class="mr-3 flex">   
                                <div class="mb-4 mr-3">
                                    <label for="foticlient_account" class="block text-gray-700 text-sm font-bold mb-2">Ｆｏｔｉｃｌｉｅｎｔアカウント</label>
                                    <input type="text" name="foticlient_account" id="foticlient_account" size="20" value="{{ old('foticlient_account', $pcLoan->foticlient_account ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline jQ-title">
                                </div>
                                                            
                                <div class="mb-4 mr-3">
                                    <label for="foticlient_pass" class="block text-gray-700 text-sm font-bold mb-2">Ｆｏｔｉｃｌｉｅｎｔパス</label>
                                    <input type="text" name="foticlient_pass" id="foticlient_pass" size="20" value="{{ old('foticlient_pass', $pcLoan->foticlient_pass ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline jQ-title">
                                </div>
                            </div>

                            <div class="mr-3 flex">   
                                <div class="mb-4 mr-3">
                                    <label for="employee_id" class="block text-gray-700 text-sm font-bold mb-2">使用者ID</label>
                                    <input type="text" name="employee_id" id="employee_id" size="20" value="{{ old('employee_id', $pcLoan->employee_id ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline jQ-title">
                                </div>

                                <div class="mb-4 mr-3">
                                    <label for="employee_name" class="block text-gray-700 text-sm font-bold mb-2">使用者</label>
                                    <input type="text" name="employee_name" id="employee_name" size="30" value="{{ old('employee_name', $pcLoan->employee_name ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline jQ-title">
                                </div>
                            </div>
                            <div class="mb-4 mr-3">
                                <label for="wifi" class="block text-gray-700 text-sm font-bold mb-2">ｗｉ－ｆｉ</label>
                                <input type="text" name="wifi" id="wifi" size="20" value="{{ old('wifi', $pcLoan->wifi ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline jQ-title">
                            </div>
                            
                            <div class="mr-3 flex">   
                                <div class="mb-4 mr-3">
                                    <label for="ms_account" class="block text-gray-700 text-sm font-bold mb-2">ＭＳアカウント</label>
                                    <input type="text" name="ms_account" id="ms_account" size="30" value="{{ old('ms_account', $pcLoan->ms_account ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline jQ-title">
                                </div>

                                <div class="mb-4 mr-3">
                                    <label for="ms_pass" class="block text-gray-700 text-sm font-bold mb-2">ＭＳパス</label>
                                    <input type="text" name="ms_pass" id="ms_pass" size="30" value="{{ old('ms_pass', $pcLoan->ms_pass ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline jQ-title">
                                </div>
                            </div>
                        <div class="flex items-center justify-end">
                            <button id="submit-btn" type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                登録
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>