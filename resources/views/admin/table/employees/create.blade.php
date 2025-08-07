<?php

use function Psy\debug;
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($employee) ? '社員編集（ID: ' . $employee->employee_id . '）' : '社員登録' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

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

                    <form action="{{ isset($employee) ? route('admin.table.employees.update', $employee->employee_id) : route('admin.table.employees.store') }}"  method="POST">
                        @csrf
                            @if (isset($employee))
                                @method('PUT')
                            @endif
                        <div class="mb-6">
                            <a href="{{ route('admin.table.employees.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                戻る
                            </a>
                        </div>   
                        <label for="employee_id" class="block text-red-700 text-sm font-bold mb-2 ">赤字タイトルは必須項目です</label>
                        
                        <div class="mb-4">
                            <label for="employee_id" class="block text-red-700 text-sm font-bold mb-2 ">社員番号</label>
                            <input type="text" name="employee_id" id="employee_id" size="6" value="{{ old('employee_id', $employee->employee_id ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        
                        <div class="mb-4 flex">
                            <div class="mb-4 mr-3">
                                <label for="employee_name" class="block text-red-700 text-sm font-bold mb-2">社員名（漢字）</label>
                                <input type="text" name="employee_name" id="employee_name" size="20" value="{{ old('employee_name', $employee->employee_name ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>                        
                            
                            <div class="mb-4 mr-3">
                                <label for="employee_name_furigana" class="block text-gray-700 text-sm font-bold mb-2">社員名（かな）</label>
                                <input type="text" name="employee_name_furigana" id="employee_name_furigana" size="40" value="{{ old('employee_name_furigana', $employee->employee_name_furigana ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            <div class="mb-4 mr-3">
                                <label for="gender" class="block text-red-700 text-sm font-bold mb-2">性別：</label>
                                <select name="gender" id="gender" class="rounded leading-tight ">
                                    <option value=""></option>
                                    @foreach (config('const.gender') as $key=>$val)
                                        <option value="{{ $key }}"{{ old('gender', $employee->gender ?? '') == $key ? ' selected' : ''}}>{{ $val }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-4 flex">
                            <div class="mb-4 mr-3">
                                <label for="employee_class_id" class="block text-red-700 text-sm font-bold mb-2">社員区分：</label>
                                <select name="employee_class_id" id="employee_class_id" class="rounded leading-tight">
                                    <option value=""></option>
                                    @foreach (config('employee_classes') as $key=>$val)
                                        <option value="{{ $key }}"
                                            {{ old('employee_class_id', $employee->employee_class_id ?? '') == $key ? 'selected' : '' }}>
                                            {{ $val }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>                       
                            
                            <div class="mb-4 mr-3">
                                <label for="department_id" class="block text-gray-700 text-sm font-bold mb-2">部署：</label>
                                <select name="department_id" id="department_id" class="rounded leading-tight">
                                    <option value=""></option>
                                    @foreach (config('departments') as $key=>$val)
                                        <option value="{{ $key }}"
                                            {{ old('department_id', $employee->department_id ?? '') == $key ? 'selected' : '' }}>
                                            {{ $val }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-4 mr-3">
                                <label for="affiliation_id" class="block text-gray-700 text-sm font-bold mb-2">所属：</label>
                                <select name="affiliation_id" id="affiliation_id" class="rounded leading-tight">
                                    <option value=""></option>
                                    @foreach (config('affiliations') as $key=>$val)
                                        <option value="{{ $key }}"
                                            {{ old('affiliation_id', $employee->affiliation_id ?? '') == $key ? 'selected' : '' }}>
                                            {{ $val }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4 mr-3">
                                <label for="occupation_id" class="block text-gray-700 text-sm font-bold mb-2">職種：</label>
                                <select name="occupation_id" id="occupation_id" class="rounded leading-tight">
                                    <option value=""></option>
                                    @foreach (config('occupations') as $key=>$val)
                                        <option value="{{ $key }}"
                                            {{ old('occupation_id', $employee->occupation_id ?? '') == $key ? 'selected' : '' }}>
                                            {{ $val }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-4 flex">
                            <div class="mb-4 mr-3">
                                <label for="birth_date" class="block text-gray-700 text-sm font-bold mb-2">誕生日：</label>
                                <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', isset($employee->birth_date) ? \Carbon\Carbon::parse($employee->birth_date)->format('Y-m-d') : '') }}" class="shadow appearance-none border rounded  py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="mb-4 mr-3">
                                <label for="hire_date" class="block text-red-700 text-sm font-bold mb-2">入社年月日：</label>
                                <input type="date" name="hire_date" id="hire_date" value="{{ old('hire_date', isset($employee->hire_date) ? \Carbon\Carbon::parse($employee->hire_date)->format('Y-m-d') : '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                        </div>
                        
                        <div class="mb-4 flex">
                            <div class="mb-4 mr-3">
                                <label for="post_code" class="block text-gray-700 text-sm font-bold mb-2">郵便番号</label>
                                <input type="text" name="post_code" id="post_code" size="10" value="{{ old('post_code', $employee->post_code ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>   

                            <div class="mb-4 mr-3">
                                <label for="prefecture" class="block text-gray-700 text-sm font-bold mb-2">都道府県</label>
                                <input type="text" name="prefecture" id="prefecture" size="10" value="{{ old('prefecture', $employee->prefecture ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div> 

                            <div class="mb-4 mr-3">
                                <label for="municipalitie" class="block text-gray-700 text-sm font-bold mb-2">市区郡</label>
                                <input type="text" name="municipalitie" id="municipalitie" value="{{ old('municipalitie', $employee->municipalitie ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div> 
                        </div>
                        
                        <div class="mb-4 flex">
                            <div class="mb-4 mr-3">
                                <label for="address_2" class="block text-gray-700 text-sm font-bold mb-2">住所２</label>
                                <input type="text" name="address_2" id="address_2" size="60" value="{{ old('address_2', $employee->address_2 ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div> 

                            <div class="mb-4 mr-3">
                                <label for="address_3" class="block text-gray-700 text-sm font-bold mb-2">住所３</label>
                                <input type="text" name="address_3" id="address_3" size="60" value="{{ old('address_3', $employee->address_3 ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div> 
                        </div>
                        
                        <div class="mb-4 flex">
                            <div class="mb-4 mr-3">
                                <label for="phone_number" class="block text-gray-700 text-sm font-bold mb-2">電話番号</label>
                                <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $employee->phone_number ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div> 

                            <div class="mb-4 mr-3">
                                <label for="mobile_phone_number" class="block text-gray-700 text-sm font-bold mb-2">携帯電話番号</label>
                                <input type="text" name="mobile_phone_number" id="mobile_phone_number" value="{{ old('mobile_phone_number', $employee->mobile_phone_number ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div> 
                        </div>
                        
                        <div class="mb-4 flex">
                            <div class="mb-6 mr-3">
                                <label for="final_academic_date" class="block text-gray-700 text-sm font-bold mb-2">最終学歴年月：</label>
                                {{-- DateTimeオブジェクトをdatetime-local形式にフォーマット --}}
                                <input type="month" name="final_academic_date" id="final_academic_date" value="{{ old('final_academic_date', isset($employee->final_academic_date) ? \Carbon\Carbon::parse($employee->final_academic_date)->format('Y-m') : '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="mb-4 mr-3">
                                <label for="final_academic" class="block text-gray-700 text-sm font-bold mb-2">最終学歴</label>
                                <input type="text" name="final_academic" id="final_academic" value="{{ old('final_academic', $employee->final_academic ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div> 
                        </div>
                        
                        <div class="mb-4 flex">
                            <div class="mb-4 mr-3">
                                <label for="work_history_1_date" class="block text-gray-700 text-sm font-bold mb-2">職歴１年月：</label>
                                {{-- DateTimeオブジェクトをdatetime-local形式にフォーマット --}}
                                <input type="month" name="work_history_1_date" id="work_history_1_date" value="{{ old('work_history_1_date', isset($employee->work_history_1_date) ? \Carbon\Carbon::parse($employee->work_history_1_date)->format('Y-m') : '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="mb-4 mr-3">
                                <label for="work_history_1" class="block text-gray-700 text-sm font-bold mb-2">職歴１</label>
                                <input type="text" name="work_history_1" id="work_history_1" value="{{ old('work_history_1', $employee->work_history_1 ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div> 
                        </div>

                        <div class="mb-4 flex">
                            <div class="mb-4 mr-3">
                                <label for="work_history_2_date" class="block text-gray-700 text-sm font-bold mb-2">職歴２年月：</label>
                                {{-- DateTimeオブジェクトをdatetime-local形式にフォーマット --}}
                                <input type="month" name="work_history_2_date" id="work_history_2_date" value="{{ old('work_history_2_date', isset($employee->work_history_2_date) ? \Carbon\Carbon::parse($employee->work_history_2_date)->format('Y-m') : '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="mb-4 mr-3">
                                <label for="work_history_2" class="block text-gray-700 text-sm font-bold mb-2">職歴２</label>
                                <input type="text" name="work_history_2" id="work_history_2" value="{{ old('work_history_2', $employee->work_history_2 ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div> 
                        </div>

                        <div class="mb-4 flex">
                            <div class="mb-4 mr-3">
                                <label for="work_history_3_date" class="block text-gray-700 text-sm font-bold mb-2">職歴３年月：</label>
                                {{-- DateTimeオブジェクトをdatetime-local形式にフォーマット --}}
                                <input type="month" name="work_history_3_date" id="work_history_3_date" value="{{ old('work_history_3_date', isset($employee->work_history_3_date) ? \Carbon\Carbon::parse($employee->work_history_3_date)->format('Y-m') : '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="mb-4 mr-3">
                                <label for="work_history_3" class="block text-gray-700 text-sm font-bold mb-2">職歴３</label>
                                <input type="text" name="work_history_3" id="work_history_3" value="{{ old('work_history_3', $employee->work_history_3 ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div> 
                        </div>
                        <div class="mb-4 flex">
                            <div class="mb-4 mr-3">
                                <label for="work_history_4_date" class="block text-gray-700 text-sm font-bold mb-2">職歴４年月：</label>
                                {{-- DateTimeオブジェクトをdatetime-local形式にフォーマット --}}
                                <input type="month" name="work_history_4_date" id="work_history_4_date" value="{{ old('work_history_4_date', isset($employee->work_history_4_date) ? \Carbon\Carbon::parse($employee->work_history_4_date)->format('Y-m') : '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="mb-4 mr-3">
                                <label for="work_history_4" class="block text-gray-700 text-sm font-bold mb-2">職歴４</label>
                                <input type="text" name="work_history_4" id="work_history_4" value="{{ old('work_history_4', $employee->work_history_4 ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div> 
                        </div>
                        <div class="mb-4 flex">
                            <div class="mb-4 mr-3">
                                <label for="work_history_5_date" class="block text-gray-700 text-sm font-bold mb-2">職歴５年月：</label>
                                {{-- DateTimeオブジェクトをdatetime-local形式にフォーマット --}}
                                <input type="month" name="work_history_5_date" id="work_history_5_date" value="{{ old('work_history_5_date', isset($employee->work_history_5_date) ? \Carbon\Carbon::parse($employee->work_history_5_date)->format('Y-m') : '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="mb-4 mr-3">
                                <label for="work_history_5" class="block text-gray-700 text-sm font-bold mb-2">職歴５</label>
                                <input type="text" name="work_history_5" id="work_history_5" value="{{ old('work_history_5', $employee->work_history_5 ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div> 
                        </div>

                        <div class="mb-4 flex">
                            <div class="mb-4 mr-3">
                                <label for="work_history_6_date" class="block text-gray-700 text-sm font-bold mb-2">職歴６年月：</label>
                                {{-- DateTimeオブジェクトをdatetime-local形式にフォーマット --}}
                                <input type="month" name="work_history_6_date" id="work_history_6_date" value="{{ old('work_history_6_date', isset($employee->work_history_6_date) ? \Carbon\Carbon::parse($employee->work_history_6_date)->format('Y-m') : '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="mb-4 mr-3">
                                <label for="work_history_6" class="block text-gray-700 text-sm font-bold mb-2">職歴６</label>
                                <input type="text" name="work_history_6" id="work_history_6" value="{{ old('work_history_6', $employee->work_history_6 ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div> 
                        </div>
                        
                        <div class="mb-4 flex">
                            <div class="mb-4 mr-3">
                                <label for="work_history_7_date" class="block text-gray-700 text-sm font-bold mb-2">職歴７年月：</label>
                                {{-- DateTimeオブジェクトをdatetime-local形式にフォーマット --}}
                                <input type="month" name="work_history_7_date" id="work_history_7_date" value="{{ old('work_history_7_date', isset($employee->work_history_7_date) ? \Carbon\Carbon::parse($employee->work_history_7_date)->format('Y-m') : '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="mb-4 mr-3">
                                <label for="work_history_7" class="block text-gray-700 text-sm font-bold mb-2">職歴７</label>
                                <input type="text" name="work_history_7" id="work_history_7" value="{{ old('work_history_7', $employee->work_history_7 ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div> 
                        </div>

                        <div class="mb-4 flex">
                            <div class="mb-4 mr-3">
                                <label for="work_history_8_date" class="block text-gray-700 text-sm font-bold mb-2">職歴８年月：</label>
                                {{-- DateTimeオブジェクトをdatetime-local形式にフォーマット --}}
                                <input type="month" name="work_history_8_date" id="work_history_8_date" value="{{ old('work_history_8_date', isset($employee->work_history_8_date) ? \Carbon\Carbon::parse($employee->work_history_8_date)->format('Y-m') : '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="mb-4 mr-3">
                                <label for="work_history_8" class="block text-gray-700 text-sm font-bold mb-2">職歴８</label>
                                <input type="text" name="work_history_8" id="work_history_8" value="{{ old('work_history_8', $employee->work_history_8 ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div> 
                        </div>

                        <div class="mb-4 flex">
                            <div class="mb-4 mr-3">
                                <label for="work_history_9_date" class="block text-gray-700 text-sm font-bold mb-2">職歴９年月：</label>
                                {{-- DateTimeオブジェクトをdatetime-local形式にフォーマット --}}
                                <input type="month" name="work_history_9_date" id="work_history_9_date" value="{{ old('work_history_9_date', isset($employee->work_history_9_date) ? \Carbon\Carbon::parse($employee->work_history_9_date)->format('Y-m') : '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="mb-4 mr-3">
                                <label for="work_history_9" class="block text-gray-700 text-sm font-bold mb-2">職歴９</label>
                                <input type="text" name="work_history_9" id="work_history_9" value="{{ old('work_history_9', $employee->work_history_9 ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div> 
                        </div>

                        <div class="mb-4 flex">
                            <div class="mb-4 mr-3">
                                <label for="work_history_10_date" class="block text-gray-700 text-sm font-bold mb-2">職歴１０年月：</label>
                                {{-- DateTimeオブジェクトをdatetime-local形式にフォーマット --}}
                                <input type="month" name="work_history_10_date" id="work_history_10_date" value="{{ old('work_history_10_date', isset($employee->work_history_10_date) ? \Carbon\Carbon::parse($employee->work_history_10_date)->format('Y-m') : '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="mb-4 mr-3">
                                <label for="work_history_10" class="block text-gray-700 text-sm font-bold mb-2">職歴１０</label>
                                <input type="text" name="work_history_10" id="work_history_10" value="{{ old('work_history_10', $employee->work_history_10 ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div> 
                        </div>

                        <div class="mb-4">
                            <label for="license_1" class="block text-gray-700 text-sm font-bold mb-2">資格１</label>
                            <input type="text" name="license_1" id="license_1" value="{{ old('license_1', $employee->license_1 ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label for="license_2" class="block text-gray-700 text-sm font-bold mb-2">資格２</label>
                            <input type="text" name="license_2" id="license_2" value="{{ old('license_2', $employee->license_2 ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label for="license_3" class="block text-gray-700 text-sm font-bold mb-2">資格３</label>
                            <input type="text" name="license_3" id="license_3" value="{{ old('license_3', $employee->license_3 ?? '') }}" class="shadow appearance-none border rounded  py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label for="license_4" class="block text-gray-700 text-sm font-bold mb-2">資格４</label>
                            <input type="text" name="license_4" id="license_4" value="{{ old('license_4', $employee->license_4 ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label for="license_5" class="block text-gray-700 text-sm font-bold mb-2">資格５</label>
                            <input type="text" name="license_5" id="license_5" value="{{ old('license_5', $employee->license_5 ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label for="social_insurance_Applicable_date" class="block text-gray-700 text-sm font-bold mb-2">社会保険適用年月日</label>
                            {{-- DateTimeオブジェクトをdatetime-local形式にフォーマット --}}
                            <input type="date" name="social_insurance_Applicable_date" id="social_insurance_Applicable_date" value="{{ old('social_insurance_Applicable_date', isset($employee->social_insurance_Applicable_date) ? \Carbon\Carbon::parse($employee->social_insurance_Applicable_date)->format('Y-m-d') : '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4 flex">
                            <div class="mb-4 mr-3">
                                <label for="health_insurance" class="block text-gray-700 text-sm font-bold mb-2">	健康保険</label>
                                <input type="text" name="health_insurance" id="health_insurance" value="{{ old('health_insurance', $employee->health_insurance ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="mb-4 mr-3">
                                <label for="health_insurance_basic_reward_monthly_fee" class="block text-gray-700 text-sm font-bold mb-2">健康保険標準報酬月額	</label>
                                <input type="text" name="health_insurance_basic_reward_monthly_fee" id="health_insurance_basic_reward_monthly_fee" value="{{ old('health_insurance_basic_reward_monthly_fee', $employee->health_insurance_basic_reward_monthly_fee ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="mb-4 mr-3">
                                <label for="health_insurance_grade" class="block text-gray-700 text-sm font-bold mb-2">健康保険等級	</label>
                                <input type="text" name="health_insurance_grade" id="health_insurance_grade" value="{{ old('health_insurance_grade', $employee->health_insurance_grade ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                        </div>

                        <div class="mb-4 flex">
                            <div class="mb-4 mr-3">
                                <label for="basic_pension_number" class="block text-gray-700 text-sm font-bold mb-2">基礎年金番号</label>
                                <input type="text" name="basic_pension_number" id="basic_pension_number" value="{{ old('basic_pension_number', $employee->basic_pension_number ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="mb-4 mr-3">
                                <label for="welfare_pension_number" class="block text-gray-700 text-sm font-bold mb-2">厚生年金番号</label>
                                <input type="text" name="welfare_pension_number" id="welfare_pension_number" value="{{ old('welfare_pension_number', $employee->welfare_pension_number ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="mb-4 mr-3">
                                <label for="pension_basic_reward_monthly_fee" class="block text-gray-700 text-sm font-bold mb-2">年金標準報酬月額	</label>
                                <input type="text" name="pension_basic_reward_monthly_fee" id="pension_basic_reward_monthly_fee" value="{{ old('pension_basic_reward_monthly_fee', $employee->pension_basic_reward_monthly_fee ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="mb-4 mr-3">
                                <label for="pension_grade" class="block text-gray-700 text-sm font-bold mb-2">年金等級	</label>
                                <input type="text" name="pension_grade" id="pension_grade" value="{{ old('pension_grade', $employee->pension_grade ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                        </div>

                        <div class="mb-4 flex">
                            <div class="mb-4 mr-3">
                                <label for="employment_applicable_date" class="block text-gray-700 text-sm font-bold mb-2">雇用適用年月日</label>
                                {{-- DateTimeオブジェクトをdatetime-local形式にフォーマット --}}
                                <input type="date" name="employment_applicable_date" id="employment_applicable_date" value="{{ old('employment_applicable_date', isset($employee->employment_applicable_date) ? \Carbon\Carbon::parse($employee->employment_applicable_date)->format('Y-m-d') : '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="mb-4 mr-3">
                                <label for="applicable_insurance_number" class="block text-gray-700 text-sm font-bold mb-2">雇用保険番号	</label>
                                <input type="text" name="applicable_insurance_number" id="applicable_insurance_number" value="{{ old('applicable_insurance_number', $employee->applicable_insurance_number ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                        </div>

                        <div class="mb-4 flex">
                            @if (isset($employee))
                                <div class="mb-4 mr-3">
                                    <label for="retirement_date" class="block text-gray-700 text-sm font-bold mb-2">退職年月日（日付を入れると表示されなくなります）</label>
                                    {{-- DateTimeオブジェクトをdatetime-local形式にフォーマット --}}
                                    <input type="date" name="retirement_date" id="retirement_date" value="{{ old('retirement_date', isset($employee->retirement_date) ? \Carbon\Carbon::parse($employee->retirement_date)->format('Y-m-d') : '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                            @endif

                            @if (isset($employee))
                                <div class="mb-4 mr-3">
                                    <label for="retirement_reason" class="block text-gray-700 text-sm font-bold mb-2">退職理由	</label>
                                    <input type="text" name="retirement_reason" id="retirement_reason" size="50" value="{{ old('retirement_reason', $employee->retirement_reason ?? '') }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                            @endif
                        </div>
                        
                        <div class="mb-4">
                            <label for="portal_role" class="block text-red-700 text-sm font-bold mb-2">ポータル権限：</label>
                            <select name="portal_role" id="portal_role" class="rounded leading-tight">
                                @foreach (config('const.portal_role') as $key => $val)
                                    <option value="{{ $key }}"{{ old('portal_role', $employee->portal_role ?? 99) == $key ? ' selected' : '' }}>{{ $val }}</option>
                                @endforeach   
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="note" class="block text-gray-700 text-sm font-bold mb-2">備考	</label>
                            <input type="text" name="note" id="note" value="{{ old('note', $employee->note ?? '') }}" class="w-[1000px] shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                登録
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>