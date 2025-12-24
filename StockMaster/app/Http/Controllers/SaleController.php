<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('customer', 'user')->latest()->paginate(10);
        return view('sales.index', compact('sales'));
    }

    public function show(Sale $sale)
    {
        $sale->load('items.product', 'customer', 'user');
        return view('sales.show', compact('sale'));
    }

    public function receipt(Sale $sale)
    {
        $sale->load('items.product', 'customer', 'user');
        return view('sales.receipt', compact('sale'));
    }
}
