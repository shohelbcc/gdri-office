@extends('layouts.guest')
@section('title')
    {{ __(' - Login') }}
@endsection

@section('content')
    <div id="login">
        <div class="container">
            <div class="row">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4 mx-auto">
                    {{-- <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4 mx-auto"> --}}
                        <div class="card">
                            <div class="card-body py-4">
                                <div class="brand_logo d-flex justify-content-center">
                                    <a href="{{ route('home') }}">
                                        <img src="{{ asset('images/logo.png') }}" style="width: 100px; height: auto;"
                                            alt="Brand-Logo">
                                    </a>
                                </div>

                                <h4 class="my-4 fw-bold text-center">Admin Sign In</h4>
                                <div class="content">
                                    <form action="{{ route('admin.login') }}" method="post">
                                        @csrf
                                        @method('POST')

                                        {{-- 2) Hidden user_type --}}
                                        <input type="hidden" name="user_type" value="admin">

                                        <div class="form-group mb-3">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" id="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email') }}" placeholder="Email">
                                            @error('email')
                                                <div class="text-danger">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="password">Password</label>
                                            <input type="password" name="password" id="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                value="{{ old('password') }}" placeholder="Password">
                                            @error('password')
                                                <div class="text-danger">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="d-flex items-center justify-content-end mt-4">
                                            <a class="me-2 underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                href="{{ route('admin.register') }}">
                                                {{ __('Not register yet?') }}
                                            </a>
                                            @if (Route::has('password.request'))
                                                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                    href="{{ route('password.request') }}">
                                                    {{ __('Forgot your password?') }}
                                                </a>
                                            @endif

                                            <button type="submit" class="btn btn-sm btn-dark px-4 ms-2">Login</button>
                                        </div>
                                    </form>
                                </div>
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