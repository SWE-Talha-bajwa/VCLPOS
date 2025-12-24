<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $products = Product::where('user_id', $request->user()->id)
            ->latest()
            ->paginate($perPage);

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                \Illuminate\Validation\Rule::unique('products')->where(function ($query) use ($request) {
                    return $query->where('user_id', $request->user()->id);
                })
            ],
            'type' => 'required|string',
            'cost' => 'required|numeric',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'alert_quantity' => 'nullable|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product = Product::create([
            'user_id' => $request->user()->id,
            'name' => $validated['name'],
            'code' => $validated['code'],
            'type' => $validated['type'],
            'cost' => $validated['cost'],
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
            'alert_quantity' => $validated['alert_quantity'] ?? 5,
            'description' => $validated['description'] ?? null,
            'image' => $imagePath,
        ]);

        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $product = Product::where('user_id', $request->user()->id)
            ->findOrFail($id);

        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $product = Product::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                \Illuminate\Validation\Rule::unique('products')->where(function ($query) use ($request) {
                    return $query->where('user_id', $request->user()->id);
                })->ignore($product->id)
            ],
            'type' => 'required|string',
            'cost' => 'required|numeric',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'alert_quantity' => 'nullable|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $validated['name'],
            'code' => $validated['code'],
            'type' => $validated['type'],
            'cost' => $validated['cost'],
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
            'alert_quantity' => $validated['alert_quantity'] ?? $product->alert_quantity,
            'description' => $validated['description'] ?? $product->description,
            'image' => $imagePath,
        ]);

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $product = Product::where('user_id', $request->user()->id)
            ->findOrFail($id);

        // Delete image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }
}
