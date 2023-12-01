{{-- halaman register --}}
@extends('layouts.main_register')

@section('form_register')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="#" method="">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Name</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" name="name">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" name="email">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Username</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" name="username">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                </div>

                <div class="mb-3">
                    <label class="form-label">Register as:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="registration_type" id="customer"
                            value="customer">
                        <label class="form-check-label" for="customer">
                            Customer
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="registration_type" id="sales"
                            value="sales">
                        <label class="form-check-label" for="sales">
                            Sales
                        </label>
                    </div>
                </div>

                <button type="submit" name="buttonLogin" class="mt-3 btn btn-dark w-100" id="btnsubmit">Register</button>

                <div class="mt-3 text-center">
                    Already have an account? <a href="/">Login</a>
                </div>
            </form>
        </div>
    </div>
@endsection
