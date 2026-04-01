<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class ProductController extends Controller
{
  public function index()
{
    $user = Auth::user();
    
    if ($user->role === 'boss') {
        $business = $user->businesses()->first();
    } else {
        $business = \App\Models\Business::find($user->business_id);
    }
    
    $products = $business ? $business->products : collect();
    return view('products.index', compact('products', 'business'));
}

public function store(Request $request)
{
    $user = Auth::user();
    
    if ($user->role === 'boss') {
        $business = $user->businesses()->first();
    } else {
        $business = \App\Models\Business::find($user->business_id);
    }

    if (!$business) {
        return redirect()->back()->with('error', 'No business found.');
    }

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'stock_quantity' => 'required|integer|min:0',
    ]);

    $business->products()->create($validated);
    return redirect()->route('products.index')->with('success', 'Product added to stock!');
}

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        // Boss only
        if (auth()->user()->role !== 'boss') {
            return redirect()->route('products.index')->with('error', 'Only the boss can edit products.');
        }
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        // Boss only
        if (auth()->user()->role !== 'boss') {
            return redirect()->route('products.index')->with('error', 'Only the boss can update products.');
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer|min:0',
        ]);
        $product->update($validated);
        return redirect()->route('products.index')->with('success', 'Product updated!');  
    }
public function create()
{
    return view('products.create');
}4
    public function destroy(Product $product)
    {
        // Boss only
        if (auth()->user()->role !== 'boss') {
            return redirect()->route('products.index')->with('error', 'Only the boss can delete products.');
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted!');
    }
}