@extends('layouts.app-admin')
@section('content')
    @include('components.admin.services.list')
    @include('components.admin.services.create')
    @include('components.admin.services.update')
    @include('components.admin.services.delete')
@endsection
