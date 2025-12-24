<x-app-layout>
    <x-slot name="header">
        {{ __('Create Adjustment') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('adjustments.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <!-- Date -->
                            <div>
                                <x-input-label for="date" :value="__('Date')" />
                                <x-text-input id="date" class="block mt-1 w-full" type="date" name="date"
                                    :value="date('Y-m-d')" required />
                                <x-input-error :messages="$errors->get('date')" class="mt-2" />
                            </div>

                            <!-- Reference -->
                            <div>
                                <x-input-label for="reference" :value="__('Reference')" />
                                <x-text-input id="reference" class="block mt-1 w-full" type="text" name="reference"
                                    :value="'ADJ-' . date('YmdHis')" required />
                                <x-input-error :messages="$errors->get('reference')" class="mt-2" />
                            </div>

                            <!-- Note -->
                            <div>
                                <x-input-label for="note" :value="__('Note')" />
                                <x-text-input id="note" class="block mt-1 w-full" type="text" name="note"
                                    :value="old('note')" />
                                <x-input-error :messages="$errors->get('note')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Products</h3>
                            <div id="products-container" class="space-y-4">
                                <div
                                    class="product-row grid grid-cols-1 md:grid-cols-12 gap-4 items-end border p-4 rounded bg-gray-50 dark:bg-gray-700">
                                    <div class="md:col-span-5">
                                        <x-input-label :value="__('Product')" />
                                        <select name="products[0][product_id]"
                                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                            required>
                                            <option value="">Select Product</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}
                                                    ({{ $product->code }}) - Stock: {{ $product->quantity }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="md:col-span-3">
                                        <x-input-label :value="__('Type')" />
                                        <select name="products[0][type]"
                                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                            required>
                                            <option value="add">Add (+)</option>
                                            <option value="subtract">Subtract (-)</option>
                                        </select>
                                    </div>
                                    <div class="md:col-span-3">
                                        <x-input-label :value="__('Quantity')" />
                                        <x-text-input type="number" name="products[0][quantity]"
                                            class="block mt-1 w-full" min="1" required />
                                    </div>
                                    <div class="md:col-span-1">
                                        <button type="button"
                                            class="remove-row text-red-600 hover:text-red-900 font-bold hidden">X</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="add-row"
                                class="mt-4 px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">+ Add Another
                                Product</button>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('adjustments.index') }}"
                                class="text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                            <x-primary-button>
                                {{ __('Save Adjustment') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let rowCount = 1;
            const container = document.getElementById('products-container');
            const addBtn = document.getElementById('add-row');

            addBtn.addEventListener('click', function () {
                const firstRow = container.querySelector('.product-row');
                const newRow = firstRow.cloneNode(true);

                // Update names
                newRow.querySelectorAll('select, input').forEach(input => {
                    input.name = input.name.replace('[0]', '[' + rowCount + ']');
                    input.value = '';
                });

                // Show remove button
                newRow.querySelector('.remove-row').classList.remove('hidden');

                container.appendChild(newRow);
                rowCount++;
            });

            container.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-row')) {
                    e.target.closest('.product-row').remove();
                }
            });
        });
    </script>
</x-app-layout>