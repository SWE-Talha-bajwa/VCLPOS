<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $customers = Customer::all();
        return view('pos.index', compact('products', 'customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'cart' => 'required|array',
            'cart.*.id' => 'required|exists:products,id',
            'cart.*.qty' => 'required|integer|min:1',
            'cart.*.price' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        $sale = \Illuminate\Support\Facades\DB::transaction(function () use ($validated) {
            // Calculate tax amount
            $taxRate = $validated['tax_rate'] ?? 0;
            $discountAmount = $validated['discount_amount'] ?? 0;
            $taxAmount = ($validated['total_amount'] * $taxRate) / 100;

            // Create Sale
            $sale = \App\Models\Sale::create([
                'user_id' => auth()->id(),
                'customer_id' => $validated['customer_id'] ?? null,
                'total_amount' => $validated['total_amount'],
                'paid_amount' => $validated['paid_amount'],
                'tax_rate' => $taxRate,
                'tax_amount' => $taxAmount,
                'discount_amount' => $discountAmount,
                'payment_method' => $validated['payment_method'],
                'status' => 'completed',
                'notes' => $validated['notes'] ?? null,
            ]);

            // Create Sale Items and Update Stock
            foreach ($validated['cart'] as $item) {
                $product = \App\Models\Product::find($item['id']);

                \App\Models\SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'price' => $item['price'],
                    'total' => $item['qty'] * $item['price'],
                ]);

                // Decrement Stock
                $product->decrement('quantity', $item['qty']);
            }

            return $sale;
        });

        return response()->json([
            'success' => true,
            'message' => 'Sale completed successfully!',
            'sale_id' => $sale->id,
            'receipt_number' => $sale->receipt_number
        ]);
    }
}
