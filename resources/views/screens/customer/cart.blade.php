@extends('layouts.main_customer')

@section('content')
    <div class="container mt-5">
        <h2>Your Cart</h2>
        <div class="row">
            <div class="col-md-8">
                <div class="row row-cols-1 g-4">
                    @foreach ($cartItems as $cartItem)
                        <div class="col">
                            <div class="card">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="https://source.unsplash.com/400x400/?product" class="card-img-top"
                                            style="object-fit: cover;" alt="Product Image">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            @php
                                                $product = \App\Models\Product::find($cartItem->products_id);
                                            @endphp
                                            <h5 class="card-title text-right" style="font-weight: bold">{{ $product->nama }}
                                            </h5>
                                            <p class="card-text text-right">Price:
                                                Rp{{ $product->harga }}</p>
                                            <p class="card-text text-right">Qty: <span
                                                    id="qty_{{ $cartItem->id }}">{{ $cartItem->qty }}</span></p>
                                            <div class="btn-group" role="group" aria-label="Quantity">
                                                <button type="button" class="btn btn-secondary"
                                                    onclick="updateQty({{ $cartItem->id }}, 'decrement', {{ $product->id }})">-</button>
                                                <button type="button" class="btn btn-secondary"
                                                    onclick="updateQty({{ $cartItem->id }}, 'increment', {{ $product->id }})">+</button>
                                            </div>
                                            <!-- Tambahkan sesuatu agar tidak terlalu monoton -->
                                            <p class="card-text mt-2">{{ $product->description }}</p>
                                            <!-- Tambahkan tombol delete -->
                                            <button type="button" class="btn btn-danger"
                                                onclick="deleteCartItem({{ $cartItem->id }})">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title" style="font-weight: bold;">Subtotal</h5>
                        <p class="card-text" id="subtotal" style="font-weight: bold">Rp{{ $subtotal }}</p>
                        <!-- Tambahkan keterangan delivery di bawah subtotal -->
                        <p class="card-text">Delivery: Rp0,00</p>

                        <!-- Tambahkan penjelasan tentang delivery fee yang gratis -->
                        <p class="card-text">
                            Enjoy FREE delivery for orders above Rp10,000! Take advantage of this special offer and get
                            your favorite items delivered to your doorstep without any additional cost.
                        </p>

                        <!-- Tambahkan paragraf terms and conditions -->
                        <p class="card-text mt-2">By proceeding with your purchase, you agree to our <a
                                href="{{ url('/terms-and-conditions') }}" target="_blank">Terms and Conditions</a>.</p>
                        <button class="btn btn-primary">Checkout</button>
                    </div>
                </div>
            </div>

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

                    // Update the subtotal only if the response includes a valid subtotal
                    if (response.hasOwnProperty('subtotal')) {
                        $('#subtotal').text('Rp' + response.subtotal);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        // Fungsi untuk menghapus item dari keranjang
        function deleteCartItem(cartItemId) {
            $.ajax({
                url: "{{ route('cart.deleteItem') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    cartItemId: cartItemId
                },
                success: function(response) {
                    // Hapus card dari DOM
                    $('#qty_' + cartItemId).closest('.col').remove();

                    // Update subtotal
                    $('#subtotal').text('Rp' + response.subtotal);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    </script>
@endsection
