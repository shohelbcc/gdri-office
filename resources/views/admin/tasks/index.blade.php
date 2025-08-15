@extends('layouts.app-admin')
@section('content')
    @include('components.admin.tasks.list')
    @include('components.admin.tasks.create')
    @include('components.admin.tasks.update')
    @include('components.admin.tasks.delete')
    @include('components.admin.tasks.bulk-delete')
@endsection
