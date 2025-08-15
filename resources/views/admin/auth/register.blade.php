@extends('layouts.guest')
@section('title')
    {{ __(' - Login') }}
@endsection

@section('content')
    <div id="register">
        <div class="container">
            <div class="row">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4 mx-auto">
                    <div class="card">
                        <div class="card-body py-4">
                            <div class="brand_logo d-flex justify-content-center">
                                <a href="{{ route('home') }}">
                                    <img src="{{ asset('images/logo.png') }}" style="width: 150px; height: auto;" alt="Brand-Logo">
                                </a>
                            </div>
                            <h4 class="mt-4 fw-bold text-center">User Registration</h4>
                            <div class="content">
                                <form action="{{ route('admin.register') }}" method="post">
                                    @csrf
                                    @method('POST')

                                    <div class="form-group mb-3">
                                        <input type="text" name="name" id="name" class="form-control"
                                            value="{{ old('name') }}" placeholder="Full Name">
                                        @error('name')
                                            <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="text" name="phone" id="phone" class="form-control"
                                            value="{{ old('phone') }}" placeholder="Phone Number">
                                        @error('phone')
                                            <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="email" name="email" id="email" class="form-control"
                                            value="{{ old('email') }}" placeholder="Email">
                                        @error('email')
                                            <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="password" name="password" id="password" class="form-control"
                                            value="{{ old('password') }}" placeholder="Password">
                                        @error('password')
                                            <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            value="{{ old('password_confirmation') }}" class="form-control"
                                            placeholder="Confirm Password">
                                        @error('password_confirmation')
                                            <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="d-flex justify-content-end mt-5">
                                        <a href="{{ route('admin.login') }}" class="me-3">Already registered ?</a>
                                        <button type="submit" class="btn btn-sm btn-dark px-4">Register</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/credentials.css') }}">

@endpush