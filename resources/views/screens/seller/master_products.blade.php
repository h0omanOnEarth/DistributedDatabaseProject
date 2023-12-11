@extends('layouts.main_seller')

@section('content')
    <h1>Products</h1>
    <div class="row justify-content-center">
        <div class="col-md-8">
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
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->harga }}</td>
                            <td>{{ $item->stok }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ url('/seller/product/update/' . $item->kodebarang) }}">
                                        <button type="button" class="btn btn-dark buttonsubmit"
                                            name="btnupdate">Update</button>
                                    </a>
                                    <a href="{{ url('/seller/product/delete/' . $item->kodebarang) }}">
                                        <button type="button" class="btn btn-dark buttonsubmit"
                                            name="btndelete">Delete</button>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

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
@endsection
