@extends('layouts.main_admin')

@section('manage_transactions')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2>History Transaksi</h2>
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th scope="col">Kode</th>
                        <th scope="col">Nama Customer</th>
                        <th scope="col">Lokasi</th>
                        <th scope="col">Subtotal</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection
