@extends('layouts.main_seller')

@section('content')

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">{{ $error }}</div>
        @endforeach
    @endif
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('failed'))
        <div class="alert alert-danger">{{ session('failed') }}</div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2>Create Products</h2>
            <form action="{!! url('/seller/products') !!}" class="row g-3" method="POST">
                @csrf
                <div class="col-md-12">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama">
                </div>
                <div class="col-md-12">
                    <label class="form-label">Harga</label>
                    <input type="text" class="form-control" id="harga" name="harga">
                </div>
                <div class="col-12">
                    <label class="form-label">Stok</label>
                    <input type="number" class="form-control" id="stok" name="stok">
                </div>
                <div class="col-12">
                    <button type="submit" class="mt-3 btn btn-dark w-100" id="buttoncreate"
                        name="btncreate">Create</button>
                </div>
            </form>
        </div>
    </div>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Products</h2>
                <!-- Button Sync -->
                <div class="mb-3">
                    <button id="syncButton" type="button" class="btn btn-primary">Sync</button>
                </div>
            </div>

            <table class="table table-dark" id="productTable">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Nama Produk</th>
                        <th scope="col">Harga Produk</th>
                        <th scope="col">Stok Produk</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $productName => $productData)
                        <tr>
                            <td>{{ $productData['id'] }}</td>
                            <td>{{ $productName }}</td>
                            <td>{{ $productData['harga'] }}</td>
                            <td>cabang A: {{ $productData['stok'] }}, cabang B: {{ $productData['stokB'] }}, cabang C:
                                {{ $productData['stokC'] }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ url('/seller/products/update/' . $productData['id']) }}">
                                        <button type="button" class="btn btn-dark buttonsubmit"
                                            name="btnupdate">Update</button>
                                    </a>
                                    <a href="{{ url('/seller/products/delete/' . $productData['id']) }}">
                                        <button type="button" class="btn btn-dark buttonsubmit"
                                            name="btndelete">Delete</button>
                                    </a>
                                    <form action="{{ url('/seller/products/getStock') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $productData['id'] }}">
                                        <input type="number" class="form-control" name="stock_quantity"
                                            placeholder="Jumlah" required style="max-width: 100px;">
                                        <button type="submit" class="btn btn-light buttonsubmit" name="btnother">Ambil stok
                                            cabang lain</button>

                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Function to refresh the table
            function refreshTable(products) {
                var tbody = $('#productTable tbody');
                tbody.empty();

                $.each(products, function(productName, product) {
                    var row = '<tr>' +
                        '<td>' + product.id + '</td>' +
                        '<td>' + productName + '</td>' +
                        '<td>' + product.harga + '</td>' +
                        '<td>cabang A: ' + product.stok + ', cabang B: ' + product.stokB + ', cabang C: ' +
                        product.stokC +
                        '</td>' +
                        '<td>' +
                        '<div class="btn-group" role="group">' +
                        '<a href="{{ url('/seller/products/update') }}/' + product.id + '">' +
                        '<button type="button" class="btn btn-dark buttonsubmit" name="btnupdate">Update</button>' +
                        '</a>' +
                        '<a href="{{ url('/seller/products/delete') }}/' + product.id + '">' +
                        '<button type="button" class="btn btn-dark buttonsubmit" name="btndelete">Delete</button>' +
                        '</a>' +
                        '<form action="{{ url('/seller/products/getStock') }}" method="POST">' +
                        '@csrf' +
                        '<input type="hidden" name="id" value="' + product.id + '">' +
                        '<input type="number" class="form-control" name="stock_quantity" placeholder="Jumlah" required style="max-width: 100px;">' +
                        '<button type="submit" class="btn btn-light buttonsubmit" name="btnother">Ambil stok cabang lain</button>' +
                        '</form>' +
                        '</div>' +
                        '</td>' +
                        '</tr>';
                    tbody.append(row);
                });
            }

            // AJAX request using jQuery
            $('#syncButton').click(function() {
                $.ajax({
                    url: "{{ route('products.sync') }}",
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    dataType: 'json', // Make sure to specify the expected data type
                    success: function(response) {
                        console.log(response);
                        alert(response.message);

                        // If the sync is successful, refresh the table with updated data
                        refreshTable(response.products);
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
