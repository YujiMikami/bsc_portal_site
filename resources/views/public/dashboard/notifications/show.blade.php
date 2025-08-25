<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            お知らせ詳細
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 flex">
                        @if (Request::is('admin/*'))
                            <a href="{{ route('admin.notification.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                戻る
                            </a>
                            @if ($notification->start_at > now())
                                <a href="{{ route('admin.notification.edit', $notification->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 mr-4 rounded focus:outline-none focus:shadow-outline">
                                    編集
                                </a>
                            @endif
                        @else
                            <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                戻る
                            </a>
                        @endif
                    </div>
                    <div class="mb-6">
                        <p class="mb-2">タイトル : {{ $notification->title }}</p>
                        <p class="mb-2">内容 : </p>
                        <pre class="mb-2">{{ $notification->body }}</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

