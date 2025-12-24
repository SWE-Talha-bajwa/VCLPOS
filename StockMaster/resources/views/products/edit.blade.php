<x-app-layout>
    <x-slot name="header">
        {{ __('Edit Product') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Product Name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                    :value="old('name', $product->name)" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Code -->
                            <div>
                                <x-input-label for="code" :value="__('Product Code / SKU')" />
                                <x-text-input id="code" class="block mt-1 w-full" type="text" name="code"
                                    :value="old('code', $product->code)" required />
                                <x-input-error :messages="$errors->get('code')" class="mt-2" />
                            </div>

                            <!-- Type -->
                            <div>
                                <x-input-label for="type" :value="__('Product Type')" />
                                <select id="type" name="type"
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="standard" {{ old('type', $product->type) == 'standard' ? 'selected' : '' }}>Standard</option>
                                    <option value="service" {{ old('type', $product->type) == 'service' ? 'selected' : '' }}>Service</option>
                                    <option value="digital" {{ old('type', $product->type) == 'digital' ? 'selected' : '' }}>Digital</option>
                                </select>
                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            </div>

                            <!-- Cost -->
                            <div>
                                <x-input-label for="cost" :value="__('Cost Price')" />
                                <x-text-input id="cost" class="block mt-1 w-full" type="number" step="0.01" name="cost"
                                    :value="old('cost', $product->cost)" required />
                                <x-input-error :messages="$errors->get('cost')" class="mt-2" />
                            </div>

                            <!-- Price -->
                            <div>
                                <x-input-label for="price" :value="__('Selling Price')" />
                                <x-text-input id="price" class="block mt-1 w-full" type="number" step="0.01"
                                    name="price" :value="old('price', $product->price)" required />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>

                            <!-- Quantity -->
                            <div>
                                <x-input-label for="quantity" :value="__('Quantity')" />
                                <x-text-input id="quantity" class="block mt-1 w-full" type="number" name="quantity"
                                    :value="old('quantity', $product->quantity)" required />
                                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                            </div>

                            <!-- Alert Quantity -->
                            <div>
                                <x-input-label for="alert_quantity" :value="__('Alert Quantity')" />
                                <x-text-input id="alert_quantity" class="block mt-1 w-full" type="number"
                                    name="alert_quantity" :value="old('alert_quantity', $product->alert_quantity)" />
                                <x-input-error :messages="$errors->get('alert_quantity')" class="mt-2" />
                            </div>

                            <!-- Image -->
                            <div>
                                <x-input-label for="image" :value="__('Product Image')" />
                                @if($product->image)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                            class="h-20 w-20 object-cover rounded">
                                    </div>
                                @endif
                                <input id="image" type="file" name="image"
                                    class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mt-6">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="3"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('description', $product->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('products.index') }}"
                                class="text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                            <x-primary-button>
                                {{ __('Update Product') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>