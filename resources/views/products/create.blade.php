@extends('layouts.app')

@section('content')
<h1>Add Product</h1>

@if($errors->any())
    <div style="color:red">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<form action="{{ route('products.store') }}" method="POST">
    @csrf
    <input name="name" placeholder="Product Name" required>
    <br><br>
    <input name="price" placeholder="Price" type="number" step="0.01" required>
    <br><br>
    <input name="stock_quantity" placeholder="Stock Quantity" type="number" min="0" required>
    <br><br>
    <textarea name="description" placeholder="Description"></textarea>
    <br><br>
    <button type="submit">Save Product</button>
</form>
@endsection