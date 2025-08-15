@extends('layouts.app-admin')
@section('content')
    @include('components.admin.blogs.authors.list')
    @include('components.admin.blogs.authors.create')
    @include('components.admin.blogs.authors.update')
    @include('components.admin.blogs.authors.delete')
@endsection
