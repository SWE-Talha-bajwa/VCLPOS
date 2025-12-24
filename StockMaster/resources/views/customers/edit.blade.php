<x-app-layout>
    <x-slot name="header">
        {{ __('Edit Customer') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('customers.update', $customer) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                    :value="old('name', $customer->name)" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Phone -->
                            <div>
                                <x-input-label for="phone" :value="__('Phone')" />
                                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone"
                                    :value="old('phone', $customer->phone)" required />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                    :value="old('email', $customer->email)" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- City -->
                            <div>
                                <x-input-label for="city" :value="__('City')" />
                                <x-text-input id="city" class="block mt-1 w-full" type="text" name="city"
                                    :value="old('city', $customer->city)" />
                                <x-input-error :messages="$errors->get('city')" class="mt-2" />
                            </div>

                            <!-- Country -->
                            <div>
                                <x-input-label for="country" :value="__('Country')" />
                                <x-text-input id="country" class="block mt-1 w-full" type="text" name="country"
                                    :value="old('country', $customer->country)" />
                                <x-input-error :messages="$errors->get('country')" class="mt-2" />
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-2">
                                <x-input-label for="address" :value="__('Address')" />
                                <x-text-input id="address" class="block mt-1 w-full" type="text" name="address"
                                    :value="old('address', $customer->address)" />
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('customers.index') }}"
                                class="text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                            <x-primary-button>
                                {{ __('Update Customer') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>