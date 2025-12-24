<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Return Details #') . $return->id }}
            </h2>
            <button onclick="window.print()"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Print Credit Note
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg print:shadow-none">
                <div class="p-8 text-gray-900 dark:text-gray-100">

                    <!-- Header -->
                    <div
                        class="border-b border-gray-200 dark:border-gray-700 pb-6 mb-6 flex justify-between items-start">
                        <div>
                            <h1 class="text-3xl font-bold text-red-600">CREDIT NOTE</h1>
                            <p class="text-sm text-gray-500 mt-1">Return ID: #{{ $return->id }}</p>
                            <p class="text-sm text-gray-500">Date: {{ $return->created_at->format('M d, Y H:i') }}</p>
                            <p class="text-sm text-gray-500">Original Sale: #{{ $return->sale_id }}</p>
                        </div>
                        <div class="text-right">
                            <h3 class="font-bold text-lg">StockMaster Inc.</h3>
                            <p class="text-sm text-gray-500">123 Business Street</p>
                            <p class="text-sm text-gray-500">City, Country</p>
                            <p class="text-sm text-gray-500">Phone: +1 234 567 890</p>
                        </div>
                    </div>

                    <!-- Customer Info -->
                    <div class="mb-8">
                        <h3 class="text-gray-600 dark:text-gray-400 font-bold uppercase text-xs tracking-wider mb-2">
                            Customer</h3>
                        @if($return->sale->customer)
                            <p class="font-bold">{{ $return->sale->customer->name }}</p>
                            <p class="text-sm text-gray-500">{{ $return->sale->customer->email }}</p>
                            <p class="text-sm text-gray-500">{{ $return->sale->customer->phone }}</p>
                        @else
                            <p class="font-bold">Walk-in Customer</p>
                        @endif
                    </div>

                    <!-- Items Table -->
                    <table class="min-w-full mb-8">
                        <thead>
                            <tr class="border-b-2 border-gray-300 dark:border-gray-600">
                                <th class="text-left py-2 font-bold">Item</th>
                                <th class="text-center py-2 font-bold">Qty Returned</th>
                                <th class="text-right py-2 font-bold">Price</th>
                                <th class="text-right py-2 font-bold">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($return->items as $item)
                                <tr class="border-b border-gray-100 dark:border-gray-700">
                                    <td class="py-2">{{ $item->product->name }}</td>
                                    <td class="text-center py-2">{{ $item->quantity }}</td>
                                    <td class="text-right py-2">${{ number_format($item->price, 2) }}</td>
                                    <td class="text-right py-2">${{ number_format($item->total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right py-4 font-bold">Total Refund</td>
                                <td class="text-right py-4 font-bold text-xl text-red-600">
                                    ${{ number_format($return->total_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>

                    <!-- Footer -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h4 class="font-bold mb-2">Reason for Return:</h4>
                        <p class="text-gray-600 dark:text-gray-400 italic">
                            {{ $return->reason ?? 'No reason provided.' }}</p>
                    </div>

                    <div class="mt-8 text-center text-xs text-gray-400">
                        <p>Thank you for your business.</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>