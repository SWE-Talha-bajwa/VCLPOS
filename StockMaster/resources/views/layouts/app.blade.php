<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo.png') }}?v=5">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.png') }}?v=5">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/logo.png') }}?v=5">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/logo.png') }}?v=5">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}?v=5">

    <title>{{ config('app.name', 'StockMaster') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div x-data="{ sidebarOpen: false }" x-init="$nextTick(() => { /* Prevent animation on load */ })"
        class="flex h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-600 bg-opacity-75 z-20 md:hidden"></div>

        @include('layouts.navigation')

        <div class="flex-1 flex flex-col overflow-hidden relative">
            <!-- Top Header -->
            <header class="bg-white dark:bg-gray-800 shadow px-6 py-4 z-10">
                <div class="flex items-center justify-between h-16">
                    <!-- Left: Sidebar Toggle & Page Title -->
                    <div class="flex items-center flex-1 justify-start">
                        <button @click="sidebarOpen = !sidebarOpen"
                            class="text-gray-500 hover:text-gray-700 focus:outline-none mr-4">
                            <svg class="h-6 w-6 transition-transform duration-300" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path x-show="!sidebarOpen" d="M4 6H20M4 12H20M4 18H11" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path x-show="sidebarOpen" d="M6 18L18 6M6 6l12 12" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>

                        @isset($header)
                            <div
                                class="text-lg font-semibold text-gray-800 dark:text-gray-200 whitespace-nowrap overflow-hidden text-ellipsis">
                                {{ $header }}
                            </div>
                        @endisset
                    </div>

                    <!-- Center: Logo & StockMaster -->
                    <div class="flex items-center justify-center flex-shrink-0 mx-4">
                        <img src="{{ asset('images/logo.png') }}" alt="StockMaster" class="h-10 w-auto mr-2">
                        <span
                            class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-orange-500 to-blue-600 bg-clip-text text-transparent hidden sm:block">StockMaster</span>
                    </div>

                    <!-- Right: User Dropdown -->
                    <div class="flex items-center flex-1 justify-end">
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                                <span class="mr-2 text-sm sm:text-base hidden sm:block">{{ Auth::user()->name }}</span>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-50"
                                style="display: none;">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Log
                                        Out</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 dark:bg-gray-900 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>