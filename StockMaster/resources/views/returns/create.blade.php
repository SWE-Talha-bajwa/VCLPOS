<x-app-layout>
    <x-slot name="header">
        {{ __('Process Return for Sale #' . $sale->id) }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Select Items to Return</h3>

                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            <strong class="font-bold">Whoops!</strong>
                            <span class="block sm:inline">There were some problems with your input.</span>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('returns.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="sale_id" value="{{ $sale->id }}">

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Product</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Sold Qty</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Price</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Return Qty</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($sale->items as $index => $item)
                                        <tr>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $item->product->name }}
                                                <input type="hidden" name="items[{{ $index }}][id]"
                                                    value="{{ $item->product_id }}">
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $item->quantity }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                ${{ number_format($item->price, 2) }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                <input type="number" name="items[{{ $index }}][quantity]" min="0"
                                                    max="{{ $item->quantity }}" value="0"
                                                    class="w-24 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            <label for="reason"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reason for
                                Return</label>
                            <textarea name="reason" id="reason" rows="3"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('sales.show', $sale) }}"
                                class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-md mr-2 hover:bg-gray-300 dark:hover:bg-gray-600">Cancel</a>
                            <button type="submit"
                                class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">Process
                                Return</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>