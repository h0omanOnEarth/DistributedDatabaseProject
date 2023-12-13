@extends('layouts.main_customer')

@section('content')
    <div class="container mt-5">
        <h2>Your Cart</h2>
        <div class="row row-cols-1 g-4">
            @foreach ($cartItems as $cartItem)
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            @php
                                $product = \App\Models\Product::find($cartItem->products_id);
                            @endphp
                            <h5 class="card-title">{{ $product->nama }}</h5>
                            <p class="card-text">Price: Rp{{ $product->harga }}</p>
                            <p class="card-text">Qty: <span id="qty_{{ $cartItem->id }}">{{ $cartItem->qty }}</span></p>
                            <div class="btn-group" role="group" aria-label="Quantity">
                                <button type="button" class="btn btn-secondary"
                                    onclick="updateQty({{ $cartItem->id }}, 'decrement', {{ $product->id }})">-</button>
                                <button type="button" class="btn btn-secondary"
                                    onclick="updateQty({{ $cartItem->id }}, 'increment', {{ $product->id }})">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function updateQty(cartItemId, action, productId) {
            $.ajax({
                url: "{{ route('cart.updateQty') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    cartItemId: cartItemId,
                    action: action,
                    productId: productId
                },
                success: function(response) {
                    // Update the UI with the new quantity
                    $('#qty_' + cartItemId).text(response.qty);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    </script>
@endsection
