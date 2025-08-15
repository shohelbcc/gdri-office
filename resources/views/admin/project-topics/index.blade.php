@extends('layouts.app-admin')
@section('content')
    @include('components.admin.project-topics.list')
    @include('components.admin.project-topics.create')
    @include('components.admin.project-topics.update')
    @include('components.admin.project-topics.delete')
@endsection
