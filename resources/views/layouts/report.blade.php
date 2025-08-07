<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link href="{{ route('public.reports.paid-requests.index') }}" :active="request()->routeIs('public.reports.paid-requests.*')">
                        有給申請
                    </x-nav-link>
                    <x-nav-link>
                        {{ __('交通費申請') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('public.reports.safety.index') }}" :active="request()->routeIs('public.reports.safety.*')">
                        安否報告
                    </x-nav-link>
                </div>
            </div>
        </div>
    </div>
</nav>
