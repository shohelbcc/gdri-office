@extends('layouts.app-admin')
@section('content')
    @include('components.admin.blogs.posts.list')
    @include('components.admin.blogs.posts.create')
    @include('components.admin.blogs.posts.update')
    @include('components.admin.blogs.posts.delete')
@endsection
