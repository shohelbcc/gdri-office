@extends('layouts.app-admin')
@section('content')
    @include('components.admin.branches.list')
    @include('components.admin.branches.create')
    @include('components.admin.branches.update')
    @include('components.admin.branches.delete')
@endsection
