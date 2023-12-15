{{-- halaman manage products --}}
@extends('layouts.main_admin')

@section('manage_transactions')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Transactions List</h5>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="fromDate" class="form-label">From Date</label>
                                    <input type="date" class="form-control" id="fromDate" name="fromDate">
                                </div>
                                <div class="col-md-6">
                                    <label for="toDate" class="form-label">To Date</label>
                                    <input type="date" class="form-control" id="toDate" name="toDate">
                                </div>
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
