<nav x-cloak :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="bg-white dark:bg-gray-800 border-r border-gray-100 dark:border-gray-700 w-64 flex-shrink-0 fixed inset-y-0 left-0 z-30 flex flex-col"
    :style="sidebarOpen !== undefined ? 'transition: transform 300ms ease-in-out;' : ''">
    <!-- Logo & Close Button -->
    <div class="h-24 flex items-center justify-between px-4 border-b border-gray-100 dark:border-gray-700">
        <div class="flex-1 flex justify-center">
            <a href="{{ route('dashboard') }}">
                <x-application-logo class="block h-24 w-auto fill-current text-gray-800 dark:text-gray-200" />
            </a>
        </div>
        <button @click="sidebarOpen = false" class="text-gray-500 hover:text-gray-700 focus:outline-none">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </button>
    </div>

    <!-- Navigation Links -->
    <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
            class="flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                </path>
            </svg>
            {{ __('Dashboard') }}
        </x-responsive-nav-link>

        <x-responsive-nav-link :href="route('pos.index')" :active="request()->routeIs('pos.index')"
            class="flex items-center text-indigo-400 font-bold">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                </path>
            </svg>
            {{ __('POS System') }}
        </x-responsive-nav-link>

        <x-responsive-nav-link :href="route('sales.index')" :active="request()->routeIs('sales.*')"
            class="flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
            </svg>
            {{ __('Sales List') }}
        </x-responsive-nav-link>

        <x-responsive-nav-link :href="route('returns.index')" :active="request()->routeIs('returns.*')"
            class="flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z">
                </path>
            </svg>
            {{ __('Returns') }}
        </x-responsive-nav-link>

        <div class="pt-4 pb-2">
            <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                Inventory
            </p>
        </div>
        <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')"
            class="flex items-center">
            {{ __('Products') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('adjustments.index')" :active="request()->routeIs('adjustments.*')"
            class="flex items-center">
            {{ __('Adjustments') }}
        </x-responsive-nav-link>



        <div class="pt-4 pb-2">
            <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                Sales & POS
            </p>
        </div>
        <x-responsive-nav-link :href="route('pos.index')" :active="request()->routeIs('pos.index')"
            class="flex items-center">
            {{ __('POS System') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('sales.index')" :active="request()->routeIs('sales.*')"
            class="flex items-center">
            {{ __('Sales List') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('returns.index')" :active="request()->routeIs('returns.*')"
            class="flex items-center">
            {{ __('Returns') }}
        </x-responsive-nav-link>

        <div class="pt-4 pb-2">
            <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                People
            </p>
        </div>
        <x-responsive-nav-link :href="route('customers.index')" :active="request()->routeIs('customers.*')"
            class="flex items-center">
            {{ __('Customers') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('suppliers.index')" :active="request()->routeIs('suppliers.*')"
            class="flex items-center">
            {{ __('Suppliers') }}
        </x-responsive-nav-link>
    </div>

    <!-- User Profile Dropdown (Simplified for Sidebar) -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-700">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <svg class="h-8 w-8 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div class="ml-3 flex-1 min-w-0">
                <div class="text-base font-medium text-gray-800 dark:text-gray-200 truncate">{{ Auth::user()->name }}
                </div>
                <div class="text-sm font-medium text-gray-500 truncate">{{ Auth::user()->email }}</div>
            </div>
        </div>
        <div class="mt-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="text-sm text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</nav>