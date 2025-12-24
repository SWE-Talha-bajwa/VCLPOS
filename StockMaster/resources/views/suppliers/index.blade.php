<x-app-layout>
    <x-slot name="header">
        {{ __('Suppliers') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Supplier List</h2>
                        <a href="{{ route('suppliers.create') }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Add Supplier</a>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Name</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Shop Name</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Phone</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        City</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($suppliers as $supplier)
                                    <tr>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $supplier->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $supplier->shop_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $supplier->phone }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $supplier->city }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('suppliers.show', $supplier) }}"
                                                class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                            <a href="{{ route('suppliers.edit', $supplier) }}"
                                                class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                            <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST"
                                                class="inline-block" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No
                                            suppliers found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $suppliers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>