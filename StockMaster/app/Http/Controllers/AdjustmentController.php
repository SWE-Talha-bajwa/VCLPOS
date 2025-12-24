<?php

namespace App\Http\Controllers;

use App\Models\Adjustment;
use App\Models\AdjustmentDetail;
use App\Models\Product;
use Illuminate\Http\Request;

class AdjustmentController extends Controller
{
    public function index()
    {
        $adjustments = Adjustment::with('details')->latest()->paginate(10);
        return view('adjustments.index', compact('adjustments'));
    }

    public function create()
    {
        $products = Product::all();
        return view('adjustments.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'reference' => [
                'required',
                'string',
                \Illuminate\Validation\Rule::unique('adjustments')->where(function ($query) {
                    return $query->where('user_id', auth()->id());
                })
            ],
            'note' => 'nullable|string',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.type' => 'required|in:add,subtract',
        ]);

        $adjustment = Adjustment::create([
            'user_id' => auth()->id(),
            'date' => $request->date,
            'reference' => $request->reference,
            'note' => $request->note,
        ]);

        foreach ($request->products as $item) {
            AdjustmentDetail::create([
                'adjustment_id' => $adjustment->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'type' => $item['type'],
            ]);

            $product = Product::find($item['product_id']);
            if ($item['type'] == 'add') {
                $product->increment('quantity', $item['quantity']);
            } else {
                $product->decrement('quantity', $item['quantity']);
            }
        }

        return redirect()->route('adjustments.index')->with('success', 'Adjustment created successfully.');
    }

    public function show(Adjustment $adjustment)
    {
        return view('adjustments.show', compact('adjustment'));
    }

    public function edit(Adjustment $adjustment)
    {
        // Adjustments are typically not editable to maintain audit trail
        // But if needed, logic would go here
    }

    public function update(Request $request, Adjustment $adjustment)
    {
        //
    }

    public function destroy(Adjustment $adjustment)
    {
        // Reverse stock changes before deleting
        foreach ($adjustment->details as $detail) {
            $product = Product::find($detail->product_id);
            if ($detail->type == 'add') {
                $product->decrement('quantity', $detail->quantity);
            } else {
                $product->increment('quantity', $detail->quantity);
            }
        }
        $adjustment->delete();
        return redirect()->route('adjustments.index')->with('success', 'Adjustment deleted successfully.');
    }
}
