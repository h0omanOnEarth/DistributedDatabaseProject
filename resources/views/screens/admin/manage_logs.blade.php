@extends('layouts.main_admin')

@section('manage_transactions')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2>LOGS</h2>
            <div class="table-responsive">
                <table class="table table-dark custom-table">
                    <thead>
                        <tr>
                            <th scope="col">OBJECT NAME</th>
                            <th scope="col">TIMESTAMP</th>
                            <th scope="col">SQL TEXT</th>
                            <th scope="col">STATEMENT TYPE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($raw as $item)
                        <tr>
                            <td>{{ $item->object_name }}</td>
                            <td>{{ $item->timestamp }}</td>
                            <td>{{ $item->sql_text }}</td>
                            <td>{{ $item->statement_type }}</td>
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

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
@endsection
