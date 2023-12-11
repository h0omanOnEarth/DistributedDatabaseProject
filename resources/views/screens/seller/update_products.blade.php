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

    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2>Update Product</h2>
            <form action="{{ url('/seller/products/update/' . $product->id) }}" class="row g-3" method="POST">
                @csrf
                @method('PUT')

                <div class="col-md-12">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $product->nama }}">
                </div>
                <div class="col-md-12">
                    <label class="form-label">Harga</label>
                    <input type="text" class="form-control" id="harga" name="harga" value="{{ $product->harga }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Stok</label>
                    <input type="number" class="form-control" id="stok" name="stok" value="{{ $product->stok }}">
                </div>
                <div class="col-12">
                    <button type="submit" class="mt-3 btn btn-dark w-100" id="buttonupdate"
                        name="btnupdate">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
