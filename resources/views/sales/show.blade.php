@extends('layouts.app')

@section('content')
<h1>Sale #{{ $sale->id }}</h1>
<p>Total: ${{ $sale->total_amount }}</p>
<p>Worker: {{ $sale->worker->name ?? 'N/A' }}</p>
<p>GPS Location: {{ $sale->gps_location }}</p>
<ul>
    @foreach($sale->items as $item)
        <li>{{ $item->product->name ?? 'Product deleted' }} x {{ $item->quantity }} = ${{ $item->subtotal }}</li>
    @endforeach
</ul>
<a href="{{ route('sales.index') }}">Back to Sales</a>
@endsection
