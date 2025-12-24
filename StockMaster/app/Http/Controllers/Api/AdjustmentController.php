<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Adjustment;
use App\Models\AdjustmentDetail;
use App\Models\Product;
use Illuminate\Http\Request;

class AdjustmentController extends Controller
{
    public function index(Request $request)
    {
        $adjustments = Adjustment::with('details.product')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return response()->json($adjustments);
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'reference' => [
                'required',
                'string',
                \Illuminate\Validation\Rule::unique('adjustments')->where(function ($query) use ($request) {
                    return $query->where('user_id', $request->user()->id);
                })
            ],
            'note' => 'nullable|string',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.type' => 'required|in:add,subtract',
        ]);

        $adjustment = Adjustment::create([
            'user_id' => $request->user()->id,
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

        $adjustment->load('details.product');

        return response()->json([
            'message' => 'Adjustment created successfully',
            'adjustment' => $adjustment
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $adjustment = Adjustment::with('details.product')
            ->where('user_id', $request->user()->id)
            ->findOrFail($id);

        return response()->json($adjustment);
    }

    public function destroy(Request $request, $id)
    {
        $adjustment = Adjustment::with('details')
            ->where('user_id', $request->user()->id)
            ->findOrFail($id);

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

        return response()->json([
            'message' => 'Adjustment deleted successfully'
        ]);
    }
}
