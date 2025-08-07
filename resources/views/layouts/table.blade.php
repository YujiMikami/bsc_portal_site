<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link href="{{ route('admin.table.index') }}" :active="request()->routeIs('admin.table.index')">
                        変更履歴
                    </x-nav-link>
                    <x-nav-link href="{{ route('admin.table.employees.index') }}" :active="request()->routeIs('admin.table.employees.*')">
                        社員テーブル
                    </x-nav-link>
                    <x-nav-link href="{{ route('admin.table.departments.index') }}" :active="request()->routeIs('admin.table.departments.*')">
                        部署テーブル
                    </x-nav-link>
                    <x-nav-link href="{{ route('admin.table.affiliations.index') }}" :active="request()->routeIs('admin.table.affiliations.*')">
                        所属テーブル
                    </x-nav-link>
                    <x-nav-link href="{{ route('admin.table.employee-posts.index') }}" :active="request()->routeIs('admin.table.employee-posts.*')">
                        役職テーブル
                    </x-nav-link>
                    <x-nav-link href="{{ route('admin.table.employee-classes.index') }}" :active="request()->routeIs('admin.table.employee-classes.*')">
                        社員区分テーブル
                    </x-nav-link>
                    <x-nav-link href="{{ route('admin.table.occupations.index') }}" :active="request()->routeIs('admin.table.occupations.*')">
                        職種テーブル
                    </x-nav-link>
                </div>
            </div>
        </div>
    </div>
</nav>
