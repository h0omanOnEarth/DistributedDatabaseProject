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
            <h2>Products</h2>
            <table class="table table-dark">
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
@endsection
