@extends('layouts.main_customer')

@section('content')
    <h1>Ini misal buat produk</h1>
    <p>Konten produk</p>
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
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->harga }}</td>
                            <td>{{ $item->stok }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ url('/seller/products/update/' . $item->id) }}">
                                        <button type="button" class="btn btn-dark buttonsubmit"
                                            name="btnupdate">Update</button>
                                    </a>
                                    <a href="{{ url('/seller/products/delete/' . $item->id) }}">
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
@endsection
