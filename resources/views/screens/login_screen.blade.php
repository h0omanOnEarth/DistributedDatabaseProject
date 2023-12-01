{{-- halaman login --}}
@extends('layouts.main_login')

@section('form_login')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="#" method="">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Username</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" name="username">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                </div>
                <a href="/admin/users" class="mt-3 btn btn-dark w-100" id="btnsubmit">Login</a>


                <div class="mt-3 text-center">
                    Don't have an account? <a href="/register">Register</a>
                </div>
            </form>
        </div>
    </div>
@endsection
