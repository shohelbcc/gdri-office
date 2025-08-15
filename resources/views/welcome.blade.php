@extends('layouts.app-home')
@section('content')

    <!-- District Coverage Start -->
    @include('components.home.district-coverage')
    <!-- District Coverage End -->

    <!-- Service Start -->
    @include('components.home.about-gdri')
    <!-- Service End -->

    <!-- Current Initiatives Start -->
    @include('components.home.current-initiatives')
    <!-- Current Initiatives End -->

    <!-- Current Initiatives Start -->
    @include('components.home.clients')
    <!-- Current Initiatives End -->


@endsection