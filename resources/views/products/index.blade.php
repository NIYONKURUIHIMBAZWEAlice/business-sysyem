@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
        <h1 class="text-3xl font-bold">📦 Stock / Products</h1>
        <a href="{{ route('products.create') }}" style="background:#16a34a;color:white;padding:10px 20px;border-radius:8px;text-decoration:none;font-weight:bold">
            + Add New Product
        </a>
    </div>

    @if(session('success'))
        <div style="background:#dcfce7;color:#166534;padding:12px;border-radius:8px;margin-bottom:16px">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background:#fee2e2;color:#991b1b;padding:12px;border-radius:8px;margin-bottom:16px">
            ❌ {{ session('error') }}
        </div>
    @endif

    <!-- Search bar -->
    <input type="text" id="searchInput" placeholder="🔍 Search product..." onkeyup="searchProducts()"
        style="width:100%;padding:10px 16px;border:1px solid #d1d5db;border-radius:8px;margin-bottom:20px;font-size:15px">

    <!-- Stock table -->
    <div style="overflow-x:auto">
        <table style="width:100%;border-collapse:collapse;background:white;border-radius:10px;overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,0.1)" id="productTable">
            <thead>
                <tr style="background:#f3f4f6">
                    <th style="padding:14px 16px;text-align:left;font-weight:600;color:#374151">#</th>
                    <th style="padding:14px 16px;text-align:left;font-weight:600;color:#374151">Product Name</th>
                    <th style="padding:14px 16px;text-align:left;font-weight:600;color:#374151">Price</th>
                    <th style="padding:14px 16px;text-align:left;font-weight:600;color:#374151">Stock Quantity</th>
                    <th style="padding:14px 16px;text-align:left;font-weight:600;color:#374151">Status</th>
                    @if(auth()->user()->role === 'boss')
                        <th style="padding:14px 16px;text-align:left;font-weight:600;color:#374151">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody id="productBody">
                @forelse($products as $product)
                    <tr style="border-top:1px solid #f3f4f6" class="product-row">
                        <td style="padding:14px 16px;color:#6b7280">{{ $loop->iteration }}</td>
                        <td style="padding:14px 16px;font-weight:500;color:#111827">{{ $product->name }}</td>
                        <td style="padding:14px 16px;color:#111827">${{ number_format($product->price, 2) }}</td>
                        <td style="padding:14px 16px">
                            <span style="font-weight:600;color:{{ $product->stock_quantity <= 5 ? '#dc2626' : '#16a34a' }}">
                                {{ $product->stock_quantity }}
                            </span>
                        </td>
                        <td style="padding:14px 16px">
                            @if($product->stock_quantity == 0)
                                <span style="background:#fee2e2;color:#991b1b;padding:4px 10px;border-radius:999px;font-size:12px">Out of Stock</span>
                            @elseif($product->stock_quantity <= 5)
                                <span style="background:#fef9c3;color:#854d0e;padding:4px 10px;border-radius:999px;font-size:12px">Low Stock</span>
                            @else
                                <span style="background:#dcfce7;color:#166534;padding:4px 10px;border-radius:999px;font-size:12px">In Stock</span>
                            @endif
                        </td>
                        @if(auth()->user()->role === 'boss')
                            <td style="padding:14px 16px">
                                <a href="{{ route('products.edit', $product) }}" style="background:#3b82f6;color:white;padding:6px 12px;border-radius:6px;text-decoration:none;font-size:13px;margin-right:6px">Edit</a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background:#ef4444;color:white;padding:6px 12px;border-radius:6px;border:none;cursor:pointer;font-size:13px">Delete</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding:24px;text-align:center;color:#9ca3af">No products found. Add your first product!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
function searchProducts() {
    var input = document.getElementById('searchInput').value.toLowerCase();
    var rows = document.querySelectorAll('.product-row');
    rows.forEach(function(row) {
        var name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
        row.style.display = name.includes(input) ? '' : 'none';
    });
}
</script>
@endsection