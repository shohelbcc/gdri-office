@extends('layouts.app-admin')
@section('content')
    @include('components.admin.home-accordians.list')
    @include('components.admin.home-accordians.create')
    @include('components.admin.home-accordians.update')
    @include('components.admin.home-accordians.delete')
@endsection
