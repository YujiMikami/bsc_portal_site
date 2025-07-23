<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            申請・報告
        </h2>
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            <x-nav-link>
                {{ __('有給申請') }}
            </x-nav-link>
            <x-nav-link>
                {{ __('交通費申請') }}
            </x-nav-link>
            <x-nav-link href="{{ route('public.reports.safety.index') }}">
                安否報告
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
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>