@extends('layouts.app-admin')
@section('content')
    @include('components.admin.roles.list')
    @include('components.admin.roles.create')
    @include('components.admin.roles.update')
    @include('components.admin.roles.delete')
    @include('components.admin.roles.bulk-delete')
@endsection
