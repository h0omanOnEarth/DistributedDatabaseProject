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


                        <!-- Tambahkan dropdown untuk metode pembayaran -->
                        <div class="mb-3">
                            <label for="paymentMethod" class="form-label">Payment Method</label>
                            <select class="form-select" id="paymentMethod" onchange="togglePaymentFields()">
                                <option value="cash">Cash on Delivery</option>
                                <option value="creditCard">Credit Card</option>
                            </select>
                        </div>

                        <!-- Dropdown untuk 'lokasi' -->
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <select class="form-select" id="location">
                                <!-- Iterasi melalui data lokasi yang diterima dari controller -->
                                @foreach ($locations as $id => $location)
                                    <option value="{{ $id }}">{{ $location }}</option>
                                @endforeach
                            </select>
                        </div>


                        <!-- Kolom-kolom kartu kredit (sembunyikan awalnya) -->
                        <div id="creditCardFields" style="display: none;">
                            <div class="mb-3">
                                <label for="cardNumber" class="form-label">Card Number</label>
                                <input type="text" class="form-control" id="cardNumber"
                                    placeholder="Enter your card number">
                            </div>
                            <div class="mb-3">
                                <label for="expiryDate" class="form-label">Expiry Date</label>
                                <input type="text" class="form-control" id="expiryDate" placeholder="MM/YYYY">
                            </div>
                            <!-- Tambahkan kolom lainnya seperti CVV, nama pada kartu, dsb. sesuai kebutuhan -->
                        </div>

                        <!-- Tambahkan paragraf terms and conditions -->
                        <p class="card-text mt-2">By proceeding with your purchase, you agree to our <a
                                href="{{ url('/terms-and-conditions') }}" target="_blank">Terms and Conditions</a>.</p>

                        <button class="btn btn-primary" onclick="checkout()">Checkout</button>

                    </div>
                </div>
            </div>

        </div>
    </div>

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

        function togglePaymentFields() {
            var paymentMethod = $('#paymentMethod').val();

            // Sembunyikan semua kolom pembayaran terlebih dahulu
            $('#creditCardFields').hide();

            // Tampilkan kolom yang sesuai dengan metode pembayaran yang dipilih
            if (paymentMethod === 'creditCard') {
                $('#creditCardFields').show();
            }
        }

        function checkout() {
            var locationId = $('#location').val();
            var paymentMethod = $('#paymentMethod').val();

            $.ajax({
                url: "{{ route('cart.checkout') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    location: locationId,
                    paymentMethod: paymentMethod
                },
                success: function(response) {
                    // Menampilkan SweetAlert setelah transaksi berhasil
                    Swal.fire({
                        title: 'Transaksi Berhasil',
                        text: 'Terima kasih atas pembelian Anda!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        // Jika pengguna mengklik OK, Anda dapat melakukan pengalihan halaman atau tindakan lainnya
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('cart.index') }}";
                        }
                    });
                },
                error: function(xhr, status, error) {
                    // Menampilkan SweetAlert jika terjadi error
                    Swal.fire({
                        title: 'Error',
                        text: 'Gagal melakukan transaksi. Silakan coba lagi.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    console.error(error);
                }
            });
        }
    </script>
@endsection
