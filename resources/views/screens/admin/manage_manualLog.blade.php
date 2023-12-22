@extends('layouts.main_admin')

@section('manage_transactions')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2>MANUAL LOGS</h2>
            <div class="table-responsive">
                <table class="table table-dark custom-table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Product ID</th>
                            <th scope="col">Action</th>
                            <th scope="col">Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productLogs as $log)
                            <tr>
                                <td>{{ $log->id }}</td>
                                <td>{{ $log->product_id }}</td>
                                <td>{{ $log->action }}</td>
                                <td>{{ $log->data }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .custom-table {
            width: 100%;
        }
    </style>
@endsection
