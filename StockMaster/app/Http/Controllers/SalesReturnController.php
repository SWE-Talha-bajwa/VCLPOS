<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $returns = \App\Models\SalesReturn::with(['sale', 'user'])->latest()->paginate(10);
        return view('returns.index', compact('returns'));
    }

    public function create(\App\Models\Sale $sale)
    {
        $sale->load('items.product');
        return view('returns.create', compact('sale'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'items' => 'required|array',
            'items.*.id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string',
        ]);

        $sale = \App\Models\Sale::findOrFail($validated['sale_id']);

        // Calculate total return amount and prepare items
        $totalReturnAmount = 0;
        $returnItemsData = [];

        foreach ($validated['items'] as $itemData) {
            $saleItem = $sale->items()->where('product_id', $itemData['id'])->first();

            if (!$saleItem) {
                return back()->withErrors(['items' => 'Invalid product in return request.']);
            }

            if ($itemData['quantity'] > $saleItem->quantity) {
                return back()->withErrors(['items' => "Cannot return more than purchased quantity for product ID {$itemData['id']}."]);
            }

            $lineTotal = $saleItem->price * $itemData['quantity'];
            $totalReturnAmount += $lineTotal;

            $returnItemsData[] = [
                'product_id' => $itemData['id'],
                'quantity' => $itemData['quantity'],
                'price' => $saleItem->price,
                'total' => $lineTotal,
            ];
        }

        if (empty($returnItemsData)) {
            return back()->withErrors(['items' => 'No items selected for return.']);
        }

        // DB Transaction
        $salesReturn = \Illuminate\Support\Facades\DB::transaction(function () use ($sale, $totalReturnAmount, $validated, $returnItemsData) {
            // Create Return Record
            $salesReturn = \App\Models\SalesReturn::create([
                'sale_id' => $sale->id,
                'user_id' => auth()->id(),
                'total_amount' => $totalReturnAmount,
                'reason' => $validated['reason'],
            ]);

            foreach ($returnItemsData as $data) {
                // Create Return Item
                \App\Models\SalesReturnItem::create([
                    'sales_return_id' => $salesReturn->id,
                    'product_id' => $data['product_id'],
                    'quantity' => $data['quantity'],
                    'price' => $data['price'],
                    'total' => $data['total'],
                ]);

                // Increment Stock
                $product = \App\Models\Product::find($data['product_id']);
                $product->increment('quantity', $data['quantity']);
            }

            return $salesReturn;
        });

        return redirect()->route('returns.show', $salesReturn)->with('success', 'Return processed successfully.');
    }

    public function show(\App\Models\SalesReturn $return) // Note: Route model binding might need explicit binding or parameter name matching
    {
        $return->load(['items.product', 'sale.customer', 'user']);
        return view('returns.show', compact('return'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
