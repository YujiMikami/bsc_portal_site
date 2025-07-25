<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            所属詳細（ID: {{ $affiliation->affiliation_id }}）
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-2">所属ID:{{ $affiliation->affiliation_id }}</p>
                    <p class="mb-2">所属名:{{ $affiliation->affiliation_name }}</p>
                    <p class="mb-2">説明:{{ $affiliation->affiliation_explanation }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

