@extends('layouts.app')

@section('content')
<h1>Products for {{ $business->name ?? 'your business' }}</h1>
<a href="{{ route('products.create') }}">Add Product</a>
@if(session('success')) <div>{{ session('success') }}</div> @endif
<ul>
    @foreach($products as $product)
        <li>
            {{ $product->name }} - ${{ $product->price }}
            <a href="{{ route('products.edit', $product) }}">Edit</a>
            <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </li>
    @endforeach
</ul>
@endsection
