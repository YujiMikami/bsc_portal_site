<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="sm:flex flex justify-between h-16">
            <div class="flex w-full overflow-x-auto flex-nowrap space-x-4 scrollbar-hide touch-pan-y">
                <!-- Navigation Links -->
                <div class="scrollable-x flex flex-row flex-nowrap overflow-x-auto scrollbar-hide space-x-4 sm:space-x-8 sm:-my-px sm:ms-10 max-w-max whitespace-nowrap">
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
                    <x-nav-link href="{{ route('admin.table.smartphone-loans.index') }}" :active="request()->routeIs('admin.table.smartphone-loans.*')">
                        スマートフォン貸与テーブル
                    </x-nav-link>
                    <x-nav-link href="{{ route('admin.table.pc-loans.index') }}" :active="request()->routeIs('admin.table.pc-loans.*')">
                        ＰＣ貸与テーブル
                    </x-nav-link>
                </div>
            </div>
        </div>
    </div>
</nav>
