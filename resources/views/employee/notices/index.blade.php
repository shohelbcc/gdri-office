@extends('layouts.app-admin')
@section('content')
    @include('components.employee.notices.list')
    @include('components.employee.notices.info')
    @include('components.employee.notices.update')
@endsection
