<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="sm:flex flex justify-between h-16">
            <div class="flex w-full overflow-x-auto flex-nowrap space-x-4 scrollbar-hide touch-pan-y">
                <!-- Navigation Links -->
                <div class="scrollable-x flex flex-row flex-nowrap overflow-x-auto scrollbar-hide space-x-4 sm:space-x-8 sm:-my-px sm:ms-10 max-w-max whitespace-nowrap">
                    <x-nav-link href="{{ route('public.reports.index') }}" :active="request()->routeIs('public.reports.index.*')">
                        申請一覧
                    </x-nav-link>
                    <x-nav-link href="{{ route('public.reports.paid-requests.index') }}" :active="request()->routeIs('public.reports.paid-requests.*')">
                        有給申請
                    </x-nav-link>
                    <x-nav-link>
                        交通費申請
                    </x-nav-link>
                    <x-nav-link href="{{ route('public.reports.safety.index') }}" :active="request()->routeIs('public.reports.safety.*')">
                        安否報告
                    </x-nav-link>
                </div>
            </div>
        </div>
    </div>
</nav>
