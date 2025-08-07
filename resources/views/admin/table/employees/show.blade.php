<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            社員詳細（ID: {{ $employee->employee_id }}）
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="table-auto w-full border jQ-table">
                        @foreach ($employee->getAttributes() as $key=>$val)
                            @if ($key === 'password' || $key === 'remember_token')
                                @continue
                            @endif
                            
                            @if ($key === 'final_academic_date')
                                <tr>
                                    <td class="border px-4 py-2">{{ __('table-columns.' . $key) }}</td>
                                    <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($val)->format('Y-m') }}</td>
                                </tr>
                                @continue
                            @endif                            
                            
                            @if (strpos($key, 'work_history') !== false && strpos($key, 'date') !== false)
                                <tr>
                                    <td class="border px-4 py-2">{{ __('table-columns.' . $key) }}</td>
                                    <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($val)->format('Y-m') }}</td>
                                </tr>
                                @continue
                            @endif          

                            @if (strpos($key, '_fee') !== false)
                                <tr>
                                    <td class="border px-4 py-2">{{ __('table-columns.' . $key) }}</td>
                                    <td class="border px-4 py-2">{{ number_format($val) }}円</td>
                                </tr>
                                @continue
                            @endif      

                            @if ($key === 'portal_role')
                                <tr>
                                    <td class="border px-4 py-2">{{ __('table-columns.' . $key) }}</td>
                                    <td class="border px-4 py-2">{{ config('const.portal_role.' . $val) }}</td>
                                </tr>
                                @continue
                            @endif
                            @if ($key === 'gender')
                                <tr>
                                    <td class="border px-4 py-2">{{ __('table-columns.' . $key) }}</td>
                                    <td class="border px-4 py-2">{{ config('const.gender.' . $val) }}</td>
                                </tr>
                                @continue
                            @endif
                            @if ($key === 'department_id')
                                <tr>
                                    <td class="border px-4 py-2">{{ __('table-columns.' . $key) }}</td>
                                    <td class="border px-4 py-2">{{ $employee->department->department_name ?? '未設定'  }}</td>
                                </tr>
                                @continue
                            @endif
                            @if ($key === 'affiliation_id')
                                <tr>
                                    <td class="border px-4 py-2">{{ __('table-columns.' . $key) }}</td>
                                    <td class="border px-4 py-2">{{ $employee->affiliation->affiliation_name ?? '未設定'  }}</td>
                                </tr>
                                @continue
                            @endif
                            @if ($key === 'employee_class_id')
                                <tr>
                                    <td class="border px-4 py-2">{{ __('table-columns.' . $key) }}</td>
                                    <td class="border px-4 py-2">{{ $employee->employeeClass->employee_class_name ?? '未設定' }}</td>
                                </tr>
                                @continue
                            @endif
                            @if ($key === 'occupation_id')
                                <tr>
                                    <td class="border px-4 py-2">{{ __('table-columns.' . $key) }}</td>
                                    <td class="border px-4 py-2">{{ $employee->occupation->occupation_name ?? '未設定' }}</td>
                                </tr>
                                @continue
                            @endif
                                <tr>
                                    <td class="border px-4 py-2">{{ __('table-columns.' . $key) }}</td>
                                    <td class="border px-4 py-2">{{ $val }}</td>
                                </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

