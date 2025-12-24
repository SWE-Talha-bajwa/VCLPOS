<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Receipt: ') . $sale->receipt_number }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('sales.receipt', $sale) }}"
                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                    <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                        <path fill-rule="evenodd"
                            d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>View Receipt</span>
                </a>
                <a href="{{ route('sales.return', $sale) }}"
                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                    <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" />
                    </svg>
                    <span>Return Items</span>
                </a>
                <button onclick="window.print()"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                    <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z" />
                    </svg>
                    <span>Print Invoice</span>
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg" id="invoice-area">
                <div class="p-8 text-gray-900 dark:text-gray-100">

                    <!-- Invoice Header -->
                    <div class="flex justify-between mb-8 border-b border-gray-200 dark:border-gray-700 pb-8">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">INVOICE</h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Receipt: {{ $sale->receipt_number }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Date:
                                {{ $sale->created_at->format('d-m-Y') }}
                            </p>
                        </div>
                        <div class="text-right">
                            <h2 class="text-xl font-bold text-gray-800 dark:text-white">StockMaster</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">123 Business Street</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">City, Country</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">email@example.com</p>
                        </div>
                    </div>

                    <!-- Customer Info -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Bill To:</h3>
                        @if($sale->customer)
                            <p class="text-gray-800 dark:text-white font-bold">{{ $sale->customer->name }}</p>
                            <p class="text-gray-600 dark:text-gray-400">{{ $sale->customer->email }}</p>
                            <p class="text-gray-600 dark:text-gray-400">{{ $sale->customer->phone }}</p>
                            <p class="text-gray-600 dark:text-gray-400">{{ $sale->customer->address }}</p>
                        @else
                            <p class="text-gray-600 dark:text-gray-400 italic">Walk-in Customer</p>
                        @endif
                    </div>

                    <!-- Items Table -->
                    <table class="min-w-full mb-8">
                        <thead>
                            <tr class="border-b-2 border-gray-300 dark:border-gray-600">
                                <th class="text-left py-3 text-gray-600 dark:text-gray-400 font-bold">Item</th>
                                <th class="text-center py-3 text-gray-600 dark:text-gray-400 font-bold">Qty</th>
                                <th class="text-right py-3 text-gray-600 dark:text-gray-400 font-bold">Price</th>
                                <th class="text-right py-3 text-gray-600 dark:text-gray-400 font-bold">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sale->items as $item)
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="py-4 text-gray-800 dark:text-white">{{ $item->product->name }}</td>
                                    <td class="py-4 text-center text-gray-600 dark:text-gray-400">{{ $item->quantity }}</td>
                                    <td class="py-4 text-right text-gray-600 dark:text-gray-400">
                                        ${{ number_format($item->price, 2) }}</td>
                                    <td class="py-4 text-right text-gray-800 dark:text-white font-bold">
                                        ${{ number_format($item->total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Totals -->
                    <div class="flex justify-end">
                        <div class="w-1/2">
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600 dark:text-gray-400">Subtotal:</span>
                                <span
                                    class="text-gray-800 dark:text-white font-bold">${{ number_format($sale->total_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600 dark:text-gray-400">Paid Amount:</span>
                                <span
                                    class="text-gray-800 dark:text-white font-bold">${{ number_format($sale->paid_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between border-t border-gray-300 dark:border-gray-600 pt-2">
                                <span class="text-lg font-bold text-gray-800 dark:text-white">Total:</span>
                                <span
                                    class="text-lg font-bold text-indigo-600 dark:text-indigo-400">${{ number_format($sale->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="mt-12 text-center text-sm text-gray-500 dark:text-gray-400">
                        <p>Thank you for your business!</p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #invoice-area,
            #invoice-area * {
                visibility: visible;
            }

            #invoice-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 0;
                box-shadow: none;
            }

            button,
            a {
                display: none !important;
            }
        }
    </style>
</x-app-layout>