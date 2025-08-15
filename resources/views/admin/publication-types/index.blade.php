@extends('layouts.app-admin')
@section('content')
    @include('components.admin.publication-types.list')
    @include('components.admin.publication-types.create')
    @include('components.admin.publication-types.update')
    @include('components.admin.publication-types.delete')
@endsection
