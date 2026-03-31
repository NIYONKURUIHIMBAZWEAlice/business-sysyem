@extends('layouts.app')

@section('content')
<h1>Sales</h1>
@if(session('success')) <div>{{ session('success') }}</div> @endif
<a href="{{ route('sales.create') }}">Record New Sale</a>
<ul>
    @foreach($sales as $sale)
        <li>
            Sale #{{ $sale->id }} - ${{ $sale->total_amount }}
            <a href="{{ route('sales.show', $sale) }}">View</a>
            <form action="{{ route('sales.destroy', $sale) }}" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </li>
    @endforeach
</ul>
@endsection
