@extends('layouts.app')

@section('content')
<h1>Edit Product</h1>
<form action="{{ route('products.update', $product) }}" method="POST">
    @csrf @method('PUT')
    <input name="name" value="{{ $product->name }}" required>
    <input name="price" value="{{ $product->price }}" type="number" step="0.01" required>
    <textarea name="description">{{ $product->description }}</textarea>
    <button type="submit">Update</button>
</form>
@endsection
