@extends('layouts.app-admin')
@section('content')
    @include('components.employee.attendances.list')
    @include('components.employee.attendances.create')
    @include('components.employee.attendances.update')
    {{-- @include('components.employee.attendances.delete')
    @include('components.employee.attendances.bulk-delete') --}}
@endsection
