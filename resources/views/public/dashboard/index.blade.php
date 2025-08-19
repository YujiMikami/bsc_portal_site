<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ダッシュボード
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (!empty($message))
                <div class="p-6 text-red-500">
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded relative" role="alert">
                        @foreach ($message as $val)
                            <p>{{ $val }}</p>
                        @endforeach
                    </div>    
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="card p-6">
                    @can('access-admin-panel')
                        <a href="{{ route('admin.notification.index') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            お知らせ管理
                        </a>
                    @endcan
                
                    <h2 class="mt-6">📢 お知らせ</h2>
                    <ul>
                        @forelse($notifications as $notice)
                        <li>
                        <a href="{{ route('public.notification.show', $notice->id) }}">
                                    {{ $notice->title }}
                                </a>
                                <span class="text-sm text-gray-500">{{ $notice->start_at->format('Y/m/d') }}</span>
                                <span class="text-sm {{ optional(optional($notice->employees->first())->pivot)->read_at ? 'text-blue-500' : 'text-red-500' }}">
                                    {{ optional(optional($notice->employees->first())->pivot)->read_at ? '既読' : '未読' }}
                                </span>
                            </li>
                        @empty
                            <li>現在お知らせはありません</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
