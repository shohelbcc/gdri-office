@extends('layouts.app-admin')
@section('content')
    @include('components.admin.publications.list')
    @include('components.admin.publications.create')
    @include('components.admin.publications.update')
    @include('components.admin.publications.delete')
@endsection
