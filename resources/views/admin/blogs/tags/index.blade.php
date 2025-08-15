@extends('layouts.app-admin')
@section('content')
    @include('components.admin.blogs.tags.list')
    @include('components.admin.blogs.tags.create')
    @include('components.admin.blogs.tags.update')
    @include('components.admin.blogs.tags.delete')
@endsection
