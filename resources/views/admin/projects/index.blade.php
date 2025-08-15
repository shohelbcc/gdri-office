@extends('layouts.app-admin')
@section('content')
    @include('components.admin.projects.list')
    @include('components.admin.projects.create')
    @include('components.admin.projects.update')
    @include('components.admin.projects.delete')
@endsection
