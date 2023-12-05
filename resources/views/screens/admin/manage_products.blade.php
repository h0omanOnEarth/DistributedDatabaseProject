{{-- halaman manage products --}}
@extends('layouts.main_admin')

@section('manage_products')
    <div class="container mt-5">
        <div class="row">
            <!-- Card untuk menampilkan daftar dalam bentuk tabel -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Products List</h5>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="searchBar" placeholder="Search">
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Tambahkan data sesuai dengan yang dimiliki -->
                                <tr>
                                    <td>Product 1</td>
                                    <td>Description 1</td>
                                    <td>Category 1</td>
                                    <td>Price 1</td>
                                </tr>
                                <tr>
                                    <td>Product 2</td>
                                    <td>Description 2</td>
                                    <td>Category 2</td>
                                    <td>Price 2</td>
                                </tr>
                                <!-- Tambahkan data lainnya di sini -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
