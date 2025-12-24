<x-app-layout>
    <x-slot name="header">
        {{ __('Supplier Details') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">{{ $supplier->name }}</h2>
                        <a href="{{ route('suppliers.index') }}"
                            class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">Back to List</a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Contact Information</h3>
                            <div class="mt-4 space-y-2">
                                <p><span class="font-semibold">Phone:</span> {{ $supplier->phone }}</p>
                                <p><span class="font-semibold">Email:</span> {{ $supplier->email ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Business Details</h3>
                            <div class="mt-4 space-y-2">
                                <p><span class="font-semibold">Shop Name:</span> {{ $supplier->shop_name ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Address</h3>
                            <div class="mt-4 space-y-2">
                                <p><span class="font-semibold">Address:</span> {{ $supplier->address ?? 'N/A' }}</p>
                                <p><span class="font-semibold">City:</span> {{ $supplier->city ?? 'N/A' }}</p>
                                <p><span class="font-semibold">Country:</span> {{ $supplier->country ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <a href="{{ route('suppliers.edit', $supplier) }}"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 mr-2">Edit
                            Supplier</a>
                        <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="inline-block"
                            onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Delete
                                Supplier</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>