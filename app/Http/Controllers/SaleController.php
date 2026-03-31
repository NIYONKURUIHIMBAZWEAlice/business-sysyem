<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Worker;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $worker = Auth::user();
        // Only show sales for the worker's business
        $sales = Sale::where('worker_id', $worker->id)->with('items')->latest()->get();
        return view('sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $worker = Auth::user();
        $products = Product::where('business_id', $worker->business_id)->get();
        return view('sales.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $worker = Auth::user();
        $validated = $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'gps_location' => 'nullable|string',
        ]);

        $total = 0;
        foreach ($validated['products'] as $item) {
            $product = Product::find($item['id']);
            $total += $product->price * $item['quantity'];
        }

        $sale = Sale::create([
            'business_id' => $worker->business_id,
            'worker_id' => $worker->id,
            'total_amount' => $total,
            'gps_location' => $request->gps_location,
        ]);

        foreach ($validated['products'] as $item) {
            $product = Product::find($item['id']);
            $sale->items()->create([
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $product->price,
                'subtotal' => $product->price * $item['quantity'],
            ]);
        }
 // Fire real-time notification
    event(new \App\Events\SaleRecorded($sale));
        return redirect()->route('sales.index')->with('success', 'Sale recorded!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        $sale->load('items.product');
        return view('sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        // Optional: implement if you want to allow editing sales
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        // Optional: implement if you want to allow updating sales
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Sale deleted!');
    }
}
