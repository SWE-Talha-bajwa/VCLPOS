<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $suppliers = Supplier::where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return response()->json($suppliers);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'nullable|email|max:255',
                'phone' => 'required|string|max:20',
                'shop_name' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:100',
                'country' => 'nullable|string|max:100',
            ]);

            $validated['user_id'] = $request->user()->id;

            // Log the attempt
            \Illuminate\Support\Facades\Log::info('Creating supplier for user: ' . $request->user()->id, $validated);

            $supplier = Supplier::create($validated);

            return response()->json([
                'message' => 'Supplier created successfully',
                'supplier' => $supplier
            ], 201);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error creating supplier: ' . $e->getMessage());
            return response()->json(['message' => 'Server Error: ' . $e->getMessage()], 500);
        }
    }

    public function show(Request $request, $id)
    {
        $supplier = Supplier::where('user_id', $request->user()->id)
            ->findOrFail($id);

        return response()->json($supplier);
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'shop_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
        ]);

        $supplier->update($validated);

        return response()->json([
            'message' => 'Supplier updated successfully',
            'supplier' => $supplier
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $supplier = Supplier::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $supplier->delete();

        return response()->json([
            'message' => 'Supplier deleted successfully'
        ]);
    }
}
