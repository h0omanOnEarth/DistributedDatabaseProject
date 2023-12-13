{{-- halaman manage users --}}
@extends('layouts.main_admin')

@section('manage_users')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
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
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->username }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->role }}</td>
                                        <td>
                                            @if ($item->role == 'admin')
                                                <button type="button" class="btn btn-danger" name="btnblock"
                                                    disabled>Block</button>
                                            @else
                                                <a href="{{ url('/admin/users/block/' . $item->id) }}">
                                                    <button type="button" class="btn btn-danger"
                                                        name="btnblock">{{ $item->status == 0 ? 'Unblock' : 'Block' }}</button>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
