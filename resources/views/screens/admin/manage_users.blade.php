{{-- halaman manage users --}}
@extends('layouts.main_admin')

@section('manage_users')
    <div class="container mt-5">
        <div class="row">
            <!-- Card untuk menampilkan form -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add User</h5>
                        <form action="#" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Role</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="role" id="customer"
                                        value="customer">
                                    <label class="form-check-label" for="customer">Customer</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="role" id="sales"
                                        value="sales">
                                    <label class="form-check-label" for="sales">Sales</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="role" id="admin"
                                        value="admin">
                                    <label class="form-check-label" for="admin">Admin</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Card untuk menampilkan daftar dalam bentuk tabel -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Users List</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Tambahkan data sesuai dengan yang dimiliki -->
                                <tr>
                                    <td>John Doe</td>
                                    <td>johndoe</td>
                                    <td>johndoe@example.com</td>
                                    <td>Admin</td>
                                    <td>
                                        <button class="btn btn-danger">Ban</button> <!-- Tambahkan button Ban -->
                                    </td>
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
