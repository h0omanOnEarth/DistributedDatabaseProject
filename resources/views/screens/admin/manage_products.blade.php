@extends('layouts.main_admin')

@section('manage_products')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Products List</h5>
                        <button id="syncButton" class="btn btn-primary">Sync</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-dark">
                            <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col">Nama Produk</th>
                                    <th scope="col">Harga Produk</th>
                                    <th scope="col">Stok Produk</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->harga }}</td>
                                        <td>{{ $item->stok }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // AJAX request using jQuery
            $('#syncButton').click(function() {
                $.ajax({
                    url: "{{ route('products.sync') }}",
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        alert(response.message);
                    },
                    error: function(error) {
                        console.error('Error during sync:', error);
                        alert('Failed to sync products');
                    }
                });
            });
        });
    </script>
@endsection
