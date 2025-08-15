@extends('layouts.app-admin')
@section('content')
    @include('components.admin.tasks.completed-list')
    @include('components.admin.tasks.delete')
@endsection
