@extends('layouts.app-admin')
@section('content')
    @include('components.admin.blogs.categories.list')
    @include('components.admin.blogs.categories.create')
    @include('components.admin.blogs.categories.update')
    @include('components.admin.blogs.categories.delete')
@endsection
