<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link href="{{ route('admin.system.log.index') }}" :active="request()->routeIs('admin.system.log.*')">
                        ログ管理
                    </x-nav-link>

                </div>
            </div>
        </div>
    </div>
</nav>
