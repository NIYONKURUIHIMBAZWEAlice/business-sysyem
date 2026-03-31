@extends('layouts.app')

@section('content')
<h1>Record Sale</h1>
<form action="{{ route('sales.store') }}" method="POST" id="saleForm">
    @csrf
    <div id="products">
        @foreach($products as $product)
            <div>
                <label>
                    <input type="checkbox" name="products[{{ $loop->index }}][id]" value="{{ $product->id }}" class="product-checkbox" data-price="{{ $product->price }}">
                    {{ $product->name }} (${{ $product->price }})
                </label>
                <input type="number" name="products[{{ $loop->index }}][quantity]" min="1" value="1" class="quantity-input" data-price="{{ $product->price }}" disabled>
            </div>
        @endforeach
    </div>
    <input name="gps_location" placeholder="GPS Location">
    <div>Total: $<span id="totalAmount">0.00</span></div>
    <button type="submit">Save Sale</button>
</form>
<script>
    const checkboxes = document.querySelectorAll('.product-checkbox');
    const quantityInputs = document.querySelectorAll('.quantity-input');
    const totalAmount = document.getElementById('totalAmount');

    function updateTotal() {
        let total = 0;
        quantityInputs.forEach((input, idx) => {
            if (checkboxes[idx].checked) {
                total += parseFloat(input.dataset.price) * parseInt(input.value || 0);
            }
        });
        totalAmount.textContent = total.toFixed(2);
    }

    checkboxes.forEach((checkbox, idx) => {
        checkbox.addEventListener('change', function() {
            quantityInputs[idx].disabled = !checkbox.checked;
            updateTotal();
        });
    });
    quantityInputs.forEach(input => {
        input.addEventListener('input', updateTotal);
    });
</script>
@endsection
