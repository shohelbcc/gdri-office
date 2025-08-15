@extends('layouts.app-admin')
@section('content')
    @include('components.employee.leave-applications.list')
    @include('components.employee.leave-applications.create')
    @include('components.employee.leave-applications.update')
    @include('components.employee.leave-applications.delete')
@endsection
