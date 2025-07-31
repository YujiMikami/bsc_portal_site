<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            CSVエクスポート
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1>出力したい項目を選択してください。</h1>
                    <!-- 全選択 / 全解除ボタン -->
                    
                    
                    <form method="POST" action="{{ route('admin.table.employees.downloadcsv') }}" id="columnsForm">
                        @csrf    
                        <div class="mb-4">
                            <button type="button" onclick="checkAllInForm(true)" class="bg-green-500 text-white px-4 py-2 rounded mr-2">すべて選択</button>
                            <button type="button" onclick="checkAllInForm(false)" class="bg-red-500 text-white px-4 py-2 rounded mr-2">すべて解除</button>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" style="padding: 8px 15px;">ダウンロード</button><br>
                        </div>

                        <div class="mb-4 flex mr-4 items-center">
                            <div class="mb-4 mr-3">
                                <label><input type="checkbox" name="in_retired_persons" value="1"> 退職者含む</label><br>
                            </div>
                            
                            <div class="mb-4 mr-3">
                                <label for="employee_class_id" class="block text-gray-700 text-sm font-bold mb-2">社員区分で絞る</label>
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
                                <label for="department_id" class="block text-gray-700 text-sm font-bold mb-2">部署で絞る</label>
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
                                <label for="affiliation_id" class="block text-gray-700 text-sm font-bold mb-2">所属で絞る</label>
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
                                <label for="occupation_id" class="block text-gray-700 text-sm font-bold mb-2">職種で絞る</label>
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

                        <div class="mb-4 flex mr-4">
                            <div class="flex-1">
                                <label><input type="checkbox" name="columns[]" value="employee_id"> 社員ID</label><br>
                                <label><input type="checkbox" name="columns[]" value="employee_name"> 社員名（漢字）</label><br>
                                <label><input type="checkbox" name="columns[]" value="employee_name_furigana"> 社員名（かな）</label><br>
                                <label><input type="checkbox" name="columns[]" value="gender"> 性別</label><br>
                                <label><input type="checkbox" name="columns[]" value="employee_class_name"> 社員区分</label><br>
                                <label><input type="checkbox" name="columns[]" value="department_name"> 部署</label><br>
                                <label><input type="checkbox" name="columns[]" value="affiliation_name"> 所属</label><br>
                                <label><input type="checkbox" name="columns[]" value="occupation_name"> 職種</label><br>
                                <label><input type="checkbox" name="columns[]" value="birth_date"> 生年月日</label><br>
                                <label><input type="checkbox" name="columns[]" value="hire_date"> 入社年月日</label><br>
                            </div>
                            <div class="flex-1">
                                <label><input type="checkbox" name="columns[]" value="post_code"> 郵便番号</label><br>
                                <label><input type="checkbox" name="columns[]" value="prefecture"> 都道府県</label><br>
                                <label><input type="checkbox" name="columns[]" value="municipalitie"> 市区郡</label><br>
                                <label><input type="checkbox" name="columns[]" value="address_2"> 住所２</label><br>
                                <label><input type="checkbox" name="columns[]" value="address_3"> 住所３</label><br>
                                <label><input type="checkbox" name="columns[]" value="phone_number"> 電話番号</label><br>
                                <label><input type="checkbox" name="columns[]" value="mobile_phone_number"> 携帯電話番号</label><br>
                            </div>
                            <div class="flex-1">
                                <label><input type="checkbox" name="columns[]" value="final_academic_date"> 最終学歴年月</label><br>
                                <label><input type="checkbox" name="columns[]" value="final_academic"> 最終学歴</label><br>
                                <label><input type="checkbox" name="columns[]" value="work_history_1_date"> 職歴１年月</label><br>
                                <label><input type="checkbox" name="columns[]" value="work_history_1"> 職歴１</label><br>
                                <label><input type="checkbox" name="columns[]" value="work_history_2_date"> 職歴２年月</label><br>
                                <label><input type="checkbox" name="columns[]" value="work_history_2"> 職歴２</label><br>
                                <label><input type="checkbox" name="columns[]" value="work_history_3_date"> 職歴３年月</label><br>
                                <label><input type="checkbox" name="columns[]" value="work_history_3"> 職歴３</label><br>
                                <label><input type="checkbox" name="columns[]" value="work_history_4_date"> 職歴４年月</label><br>
                                <label><input type="checkbox" name="columns[]" value="work_history_4"> 職歴４</label><br>
                                <label><input type="checkbox" name="columns[]" value="work_history_5_date"> 職歴５年月</label><br>
                                <label><input type="checkbox" name="columns[]" value="work_history_5"> 職歴５</label><br>
                                <label><input type="checkbox" name="columns[]" value="work_history_6_date"> 職歴６年月</label><br>
                                <label><input type="checkbox" name="columns[]" value="work_history_6"> 職歴６</label><br>
                                <label><input type="checkbox" name="columns[]" value="work_history_7_date"> 職歴７年月</label><br>
                                <label><input type="checkbox" name="columns[]" value="work_history_7"> 職歴７</label><br>
                                <label><input type="checkbox" name="columns[]" value="work_history_8_date"> 職歴８年月</label><br>
                                <label><input type="checkbox" name="columns[]" value="work_history_8"> 職歴８</label><br>
                                <label><input type="checkbox" name="columns[]" value="work_history_9_date"> 職歴９年月</label><br>
                                <label><input type="checkbox" name="columns[]" value="work_history_9"> 職歴９</label><br>
                                <label><input type="checkbox" name="columns[]" value="work_history_10_date"> 職歴１０年月</label><br>
                                <label><input type="checkbox" name="columns[]" value="work_history_10"> 職歴１０</label><br>
                            </div>
                            <div class="flex-1">
                                <label><input type="checkbox" name="columns[]" value="license_1"> 資格１</label><br>
                                <label><input type="checkbox" name="columns[]" value="license_2"> 資格２</label><br>
                                <label><input type="checkbox" name="columns[]" value="license_3"> 資格３</label><br>
                                <label><input type="checkbox" name="columns[]" value="license_4"> 資格４</label><br>
                                <label><input type="checkbox" name="columns[]" value="license_5"> 資格５</label><br>
                            </div>
                            <div class="flex-1">
                                <label><input type="checkbox" name="columns[]" value="social_insurance_Applicable_date"> 社会保険適用年月日</label><br>
                                <label><input type="checkbox" name="columns[]" value="health_insurance"> 健康保険</label><br>
                                <label><input type="checkbox" name="columns[]" value="basic_pension_number"> 基礎年金番号</label><br>
                                <label><input type="checkbox" name="columns[]" value="welfare_pension_number"> 厚生年金番号</label><br>
                                <label><input type="checkbox" name="columns[]" value="health_insurance_basic_reward_monthly_fee"> 健康保険標準報酬月額</label><br>
                                <label><input type="checkbox" name="columns[]" value="health_insurance_grade"> 健康保険等級</label><br>
                                <label><input type="checkbox" name="columns[]" value="pension_basic_reward_monthly_fee"> 年金標準報酬月額</label><br>
                                <label><input type="checkbox" name="columns[]" value="pension_grade"> 年金等級</label><br>
                                <label><input type="checkbox" name="columns[]" value="employment_applicable_date"> 雇用適用年月日</label><br>
                                <label><input type="checkbox" name="columns[]" value="applicable_insurance_number"> 雇用保険番号</label><br>
                                <label><input type="checkbox" name="columns[]" value="employee_class_updated_at"> 社員区分変更日</label><br>
                            </div>
                            <div class="flex-1">
                                <label><input type="checkbox" name="columns[]" value="retirement_date"> 退職日</label><br>
                                <label><input type="checkbox" name="columns[]" value="retirement_reason"> 退職理由</label><br>
                                <label><input type="checkbox" name="columns[]" value="retirement_reason"> 備考</label><br>
                                <label><input type="checkbox" name="columns[]" value="portal_role"> ポータル権限</label><br>
                                <label><input type="checkbox" name="columns[]" value="created_at"> 作成日</label><br>
                                <label><input type="checkbox" name="columns[]" value="updated_at"> 更新日</label><br>
                                <label><input type="checkbox" name="columns[]" value="updated_by"> 更新者</label><br>
                            </div>
                        </div>

                        
                        
                        



                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- JavaScript -->
<script>
    function checkAllInForm(checked) {
        const form = document.getElementById('columnsForm');
        const checkboxes = form.querySelectorAll('input[type="checkbox"][name="columns[]"]');
        checkboxes.forEach(cb => cb.checked = checked);
    }
</script>

</x-app-layout>

