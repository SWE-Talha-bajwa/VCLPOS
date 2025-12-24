<x-app-layout>
    <x-slot name="header">
        {{ __('POS System') }}
    </x-slot>

    <script>
        // Redirect to React POS
        window.location.href = '/react/pos';
    </script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p>Redirecting to POS System...</p>
                    <p class="mt-2">If you are not redirected, <a href="/react/pos"
                            class="text-blue-600 hover:underline">click here</a>.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>