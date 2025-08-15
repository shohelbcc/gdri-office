@extends('layouts.app-admin')
@section('content')
    @include('components.admin.permissions.list')
    @include('components.admin.permissions.create')
    @include('components.admin.permissions.update')
    @include('components.admin.permissions.delete')
    @include('components.admin.permissions.bulk-delete')
@endsection
