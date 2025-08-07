<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            システム管理
        </h2>

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
                        システム全体を管理・閲覧できます。<br>
                        <div class="flex justify-start mb-4">
                    </div>
                </div>
            </div>
        </div>
    </div>
 
</x-app-layout>