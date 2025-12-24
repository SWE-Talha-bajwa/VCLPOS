<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                \Illuminate\Validation\Rule::unique('products')->where(function ($query) {
                    return $query->where('user_id', auth()->id());
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

        Product::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'code' => $request->code,
            'type' => $request->type,
            'cost' => $request->cost,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'alert_quantity' => $request->alert_quantity ?? 5,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                \Illuminate\Validation\Rule::unique('products')->where(function ($query) {
                    return $query->where('user_id', auth()->id());
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
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $request->name,
            'code' => $request->code,
            'type' => $request->type,
            'cost' => $request->cost,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'alert_quantity' => $request->alert_quantity,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
