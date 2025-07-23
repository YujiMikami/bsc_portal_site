<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            各テーブル
        </h2>
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            <x-nav-link href="{{ route('admin.table.employees.index') }}">
                社員テーブル
            </x-nav-link>
            <x-nav-link href="{{ route('admin.table.departments.index') }}">
                部署テーブル
            </x-nav-link>
            <x-nav-link href="{{ route('admin.table.affiliations.index') }}">
                所属テーブル
            </x-nav-link>
            <x-nav-link href="{{ route('admin.table.employee_posts.index') }}">
                役職テーブル
            </x-nav-link>
            <x-nav-link href="{{ route('admin.table.employee_classes.index') }}">
                社員区分テーブル
            </x-nav-link>
        </div>
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
                        このページは管理者のみアクセスできます。<br>
                        データベースにあるテーブルを直接操作できたり<br>
                        CSVでダウンロードできます。<br>
                        <div class="flex justify-start mb-4">
                    </div>
                </div>
            </div>
        </div>
    </div>
 
</x-app-layout>