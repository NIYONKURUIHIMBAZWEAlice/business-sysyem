<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Worker;
use App\Models\BusinessNotification;


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
        'payment_method' => 'required|in:cash,mobile_money',
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
        'payment_method' => $request->payment_method,
        'gps_location' => $request->gps_location,
    ]);

    foreach ($validated['products'] as $item) {
        $product = Product::find($item['id']);
        $quantitySold = $item['quantity'];

        $sale->items()->create([
            'product_id' => $product->id,
            'quantity' => $quantitySold,
            'price' => $product->price,
            'subtotal' => $product->price * $quantitySold,
        ]);

        // Check if sold more than stock
        if ($quantitySold > $product->stock_quantity) {
            BusinessNotification::create([
                'business_id' => $worker->business_id,
                'title' => '⚠️ Sale Exceeded Stock',
                'message' => 'Worker sold ' . $quantitySold . ' of ' . $product->name . ' but only ' . $product->stock_quantity . ' in stock!',
                'is_read' => false,
            ]);
        }

        // Reduce stock quantity
        $newStock = max(0, $product->stock_quantity - $quantitySold);
        $product->update(['stock_quantity' => $newStock]);

        // Check if stock is low (5 or less)
        if ($newStock <= 5) {
            BusinessNotification::create([
                'business_id' => $worker->business_id,
                'title' => '🔴 Low Stock Alert',
                'message' => $product->name . ' has only ' . $newStock . ' items left in stock. Please restock soon!',
                'is_read' => false,
            ]);

            // Fire real-time low stock alert
            event(new \App\Events\SaleRecorded($sale));
        }
    }

    // Load items with product details for notification
    $sale->load('items.product');

    // Build notification message
    $itemNames = $sale->items->map(function($item) {
        return $item->product->name . ' x' . $item->quantity;
    })->join(', ');

    $paymentMethod = $request->payment_method === 'cash' ? 'Cash' : 'Mobile Money';

    BusinessNotification::create([
        'business_id' => $worker->business_id,
        'title' => '💰 New Sale Recorded',
        'message' => 'Worker sold: ' . $itemNames . ' | Total: $' . $total . ' | Payment: ' . $paymentMethod,
        'is_read' => false,
    ]);

    // Fire real-time notification
    \Log::info('Firing SaleRecorded event for sale ID: ' . $sale->id);
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
